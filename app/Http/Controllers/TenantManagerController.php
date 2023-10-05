<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Models\Tenant;
use App\Models\Wallet;
use App\Staff;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TenantManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $tenants     = Tenant::query();
        if ($request->has('search')) {
            $sort_search = $request->search;
            $tenants     = $tenants
                ->where('code', 'like', '%'.$sort_search.'%')
                ->orWhere('name', 'like', '%'.$sort_search.'%');
        }

        $tenants = $tenants->where('is_deleted', 0)->with('host')->orderBy('created_at', 'desc');
        $tenants = $tenants->paginate(15);
        return view('backend.tenants.index', compact('tenants', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $userIdHosted = Tenant::select('host_id')->get()->pluck('host_id')->toArray();
        $users = User::where('user_type', 'host')
            ->whereNotIn('id', $userIdHosted)
            ->where('banned', 0)->get();
        return view('backend.tenants.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $tenant          = new Tenant();
        $tenant->name    = $request->name;
        $tenant->code    = $request->code;
        $tenant->host_id = $request->host_id;
        $tenant->status  = $request->status ?? 0;

        $tenant->save();

        if(!empty($tenant->host_id)) {
            DB::beginTransaction();
            try {
                $this->triggerCreateTenant($tenant);

                DB::commit();
                flash(translate('Tenant has been inserted successfully'))->success();
                return redirect()->route('tenants.index');
            } catch (\Exception $exception) {
                DB::rollBack();
                flash(translate('Tenant has been inserted failure'))->success();
                return redirect()->back();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $tenant = Tenant::where('id', $id)->first();

        $userIdHosted = Tenant::select('host_id')
            ->where('host_id', '!=', $tenant->host_id)
            ->get()->pluck('host_id')->toArray();
        $users = User::where('user_type', 'host')
            ->whereNotIn('id', $userIdHosted)->where('banned', 0)->get();

        return view('backend.tenants.edit', compact('tenant', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $tenant          = Tenant::where('id', $id)->first();
        $tenant->name    = $request->name;
        $tenant->host_id = $request->host_id;
        $tenant->status  = $request->status ?? 0;

        $tenant->save();

        if(!empty($tenant->host_id)) {
            User::where('id', $tenant->host_id)->update([
                'tenacy_id' => $tenant->code
            ]);
            Staff::where('user_id', $tenant->host_id)->update([
                'tenacy_id' => $tenant->code
            ]);
        }

        flash(translate('Tenant has been updated successfully'))->success();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $tenant             = Tenant::where('id', $id)->first();
        $tenant->is_deleted = 1;
        $tenant->save();

        flash(translate('Tenant has been deleted successfully'))->success();
        return redirect()->route('tenants.index');
    }

    public function updateStatus(Request $request)
    {
        $tenant         = Tenant::where('id', $request->id)->first();
        $tenant->status = $request->status;
        if ($tenant->save()) {
            return 1;
        }
        return 0;
    }

    private function triggerCreateTenant(Tenant  $tenant)
    {
        User::where('id', $tenant->host_id)->update([
            'tenacy_id' => $tenant->code
        ]);
        Staff::where('user_id', $tenant->host_id)->update([
            'tenacy_id' => $tenant->code
        ]);
        Addon::create([
            'name' => 'Offline Payment',
            'unique_identifier' => 'offline_payment',
            'version' => '1.0',
            'activated' => 1,
            'image' => 'offline_banner.jpg',
            'tenacy_id' => $tenant->code,
        ]);
        Wallet::create([
            'user_id' => $tenant->host_id,
            'amount' => 0,
            'payment_method' => 'Thanh toán chuyển khoản',
            'payment_details' => '',
            'approval' => 1,
            'offline_payment' => 1,
            'reciept' => 1,
            'tenacy_id' => $tenant->code,
        ]);
    }
}
