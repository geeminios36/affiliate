<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Staff;
use App\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {

        $staffs = [];
        if (Gate::allows('is-factory-people')) {
            $staffs = Staff::where(
                'department_id',
                Auth::user()->staff->department_id
            )->paginate(10);
        } else {
            $staffs = Staff::paginate(10);
        }
        return view('backend.staff.staffs.index', compact('staffs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Gate::allows('is-factory-employee')) {
            flash(translate('You have no permission to access this page'))->error();
            return back();
        }
        $roles = Role::all();
        return view('backend.staff.staffs.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::allows('is-factory-employee')) {
            flash(translate('You have no permission to access this page'))->error();
            return back();
        }
        if (User::where('email', $request->email)->first() == null) {
            // DB::beginTransaction();
            try {

                // DB::commit();
                $current_user = auth()->user();
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->mobile;
                $user->user_type = $request->user_type ?? "staff";
                $user->password = Hash::make($request->password);
                $user->tenacy_id = get_tenacy_id_for_query();
                $user->save();
                $role_id = null;

                // if current user is factory manager
                if ($current_user->user_type == "staff" &&      $current_user->staff->role->name == 'Factory manager') {
                    $role_employee = Role::where('name', 'Factory employee')->first();
                    $role_id = $role_employee->id;
                } else {
                    // if current user is admin 
                    $role_id = (int) $request->role_id;
                }


                DB::table('staff')->insert(
                    [
                        'user_id' => $user->id,
                        'role_id' => $role_id,
                        'tenacy_id' => get_tenacy_id_for_query(),
                    ]
                );
                flash(translate('Staff has been inserted successfully'))->success();
                return Redirect::to('/admin/staffs/');
            } catch (\Throwable $th) {
                // DB::rollBack();
                flash(translate('Something went wrong!'))->error();
                return back();
            }
        }

        flash(translate('Email already used'))->error();
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
    public function edit($id)
    {
        if (Gate::allows('is-factory-employee')) {
            return back();
        }
        $staff = Staff::where('id', decrypt($id))->first();
        $roles = Role::all();
        return view('backend.staff.staffs.edit', compact('staff', 'roles'));
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
        if (Gate::allows('is-factory-employee')) {
            flash(translate('You have no permission to access this page'))->error();
            return back();
        }
        $staff = Staff::where('id', $id)->first();
        $user = $staff->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;
        if (strlen($request->password) > 0) {
            $user->password = Hash::make($request->password);
        }
        $user->tenacy_id = get_tenacy_id_for_query();
        if ($user->save()) {
            $staff->role_id = $request->role_id;
            $staff->tenacy_id = get_tenacy_id_for_query();
            if ($staff->save()) {
                flash(translate('Staff has been updated successfully'))->success();
                return redirect()->route('staffs.index');
            }
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
        if (Gate::allows('is-factory-employee')) {
            flash(translate('You have no permission to access this page'))->error();
            return back();
        }
        User::destroy(Staff::where('id', $id)->first()->user->id);
        if (Staff::where('id', $id)->where('tenacy_id', get_tenacy_id_for_query())->delete()) {
            flash(translate('Staff has been deleted successfully'))->success();
            return redirect()->route('staffs.index');
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }
}
