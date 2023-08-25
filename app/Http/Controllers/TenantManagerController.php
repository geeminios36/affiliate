<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Staff;
use App\User;
use Illuminate\Http\Request;
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
        $users = User::where('user_type', 'host')->where('banned', 0)->get();
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
            User::where('id', $tenant->host_id)->update([
                'tenacy_id' => $tenant->code
            ]);
            Staff::where('user_id', $tenant->host_id)->update([
                'tenacy_id' => $tenant->code
            ]);
        }

        flash(translate('Tenant has been inserted successfully'))->success();
        return redirect()->route('tenants.index');
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

        $users = User::where('user_type', 'host')->where('banned', 0)->get();

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
        $request->validate(
            [
                'code' => ['required', 'max:50', Rule::unique(Tenant::class, 'code')->ignore($id)],
            ],
            [
                'unique' => translate('Code was taken'),
            ]);
        $tenant          = Tenant::where('id', $id)->first();
        $tenant->name    = $request->name;
        $tenant->code    = $request->code;
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
}
