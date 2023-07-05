<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;

class DemoDataControllder extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'tenacy_id' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);
    }

    /**
     * Change pass admin demo
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function changePasswordDemo(Request $request)
    {
        $password = Hash::make($request->password);
        if (DB::table('users')->where('user_type', 'admin')->where('email', $request->email)->where('tenacy_id', $request->tenacy_id)->count() > 0) {
            DB::table('users')->where('user_type', 'admin')->where('email', $request->email)->where('tenacy_id', $request->tenacy_id)->update([
                'password' => $password
            ]);
        } else {
            DB::table('users')->insert([
                'name' => $request->name, 
                'email' => $request->email, 
                'password' => $password, 
                'user_type' => 'admin',
                'address' => null, 
                'city' => null, 
                'postal_code' => null, 
                'phone' => null, 
                'country' => null, 
                'provider_id' => null, 
                'email_verified_at' => '2018-10-07 11:42:57', 
                'verification_code' => null,
                'tenacy_id' => $request->tenacy_id
            ]);
        }

        return json_encode([
            'status' => true,
            'message' => 'Success'
        ]);
    }



}
