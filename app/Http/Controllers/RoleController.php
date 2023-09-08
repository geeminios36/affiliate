<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\RoleTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $permissions_array = [
        'pos_system' => [
            "label" => 'POS System',
            "value" => 1,
            "identify" => true,
        ],
        'products' => [
            "label" => "Products",
            "value" => 2,
            "identify" => false,
        ],
        'all_orders' => [
            "label" => "All Orders",
            "value" => 3,
            "identify" => false,
        ],
        'inhouse_orders' => [
            "label" => "Inhouse orders",
            "value" => 4,
            "identify" => false,
        ],
        'seller_orders' => [
            "label" => "Seller Orders",
            "value" => 5,
            "identify" => false,
        ],
        'pick_up_point_order' => [
            "label" => "Pick-up Point Order",
            "value" => 6,
            "identify" => false,
        ],
        'refund_request' => [
            "label" => "Refunds",
            "value" => 7,
            "identify" => true,
        ],
        'customers' => [
            "label" => "Customers",
            "value" => 8,
            "identify" => false,
        ],
        'sellers' => [
            "label" => "Sellers",
            "value" => 9,
            "identify" => false,
        ],
        'reports' => [
            "label" => "Reports",
            "value" => 10,
            "identify" => false,
        ],
        'marketing' => [
            "label" => "Marketing",
            "value" => 11,
            "identify" => false,
        ],
        'support' => [
            "label" => "Support",
            "value" => 12,
            "identify" => false,
        ],
        'website_setup' => [
            "label" => "Website Setup",
            "value" => 13,
            "identify" => false,
        ],
        'setup_configurations' => [
            "label" => "Setup & Configurations",
            "value" => 14,
            "identify" => false,
        ],
        'affiliate_system' => [
            "label" => "Affiliate System",
            "value" => 15,
            "identify" => true,
        ],
        'offline_payment_system' => [
            "label" => "Offline Payment System",
            "value" => 16,
            "identify" => false,
        ],
        'paytm_payment_gateway' => [
            "label" => "Paytm Payment Gateway",
            "value" => 17,
            "identify" => true,
        ],
        'club_point_system' => [
            "label" => "Club Point System",
            "value" => 18,
            "identify" => true,
        ],
        'otp_system' => [
            "label" => "OTP System",
            "value" => 19,
            "identify" => true,
        ],
        'staffs' => [
            "label" => "Staffs",
            "value" => 20,
            "identify" => false,
        ],
        'addon_manager' => [
            "label" => "Addon Manager",
            "value" => 21,
            "identify" => false,
        ],
        'uploaded_files' => [
            "label" => "Uploaded Files",
            "value" => 22,
            "identify" => false,
        ],
        'blod_system' => [
            "label" => "Blog System",
            "value" => 23,
            "identify" => false,
        ],
        'system' => [
            "label" => "System",
            "value" => 24,
            "identify" => false,
        ],
    ];
    public function index()
    {
        $roles = Role::query();
        if(is_host()) {
            $roles->where('tenacy_id', Auth::user()->tenacy_id);
        }
        $roles = $roles->paginate(10);
        return view('backend.staff.staff_roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.staff.staff_roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('permissions')) {
            $role = new Role;
            $role->name = $request->name;
            $role->permissions = json_encode($request->permissions);
            $role->save();

            $role_translation = RoleTranslation::firstOrNew(['lang' => env('DEFAULT_LANGUAGE'), 'role_id' => $role->id]);
            $role_translation->name = $request->name;
            $role_translation->save();

            flash(translate('Role has been inserted successfully'))->success();
            return redirect()->route('roles.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
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
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang = $request->lang;
        $role = Role::where('id', $id)->first();
        $permissions_array = $this->permissions_array;
        return view('backend.staff.staff_roles.edit', compact('role', 'lang', 'permissions_array'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {

        $role = Role::where('id', $id)->first();

        if ($request->has('permissions')) {
            if ($request->lang == env("DEFAULT_LANGUAGE")) {
                $role->name = $request->name;
            }
            $role->permissions = json_encode($request->permissions);
            $role->save();

            $role_translation = RoleTranslation::firstOrNew(['lang' => $request->lang, 'role_id' => $role->id]);
            $role_translation->name = $request->name;
            $role_translation->save();

            flash(translate('Role has been updated successfully'))->success();
            return redirect()->route('roles.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::where('id', $id)->whereNotIn('name', roleNameCanNotDelete())->first();
        foreach ($role->role_translations as $key => $role_translation) {
            $role_translation->delete();
        }

        Role::where('id', $id)->where('tenacy_id', get_tenacy_id_for_query())->delete();
        flash(translate('Role has been deleted successfully'))->success();
        return redirect()->route('roles.index');
    }
}
