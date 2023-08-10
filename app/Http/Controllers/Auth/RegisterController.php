<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Customer;
use App\Cart;
use App\BusinessSetting;
use App\OtpConfiguration;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OTPVerificationController;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Cookie;
use Illuminate\Support\Str;
use Session;
use Nexmo;
use Twilio\Rest\Client;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try {
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);

                $customer = new Customer;
                $customer->user_id = $user->id;
                $customer->tenacy_id = get_tenacy_id_for_query(); $customer->save();
            }
            else {
                if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated){
                    $user = User::create([
                        'name' => $data['name'],
                        'phone' => '+'.$data['country_code'].$data['phone'],
                        'password' => Hash::make($data['password']),
                        'verification_code' => rand(100000, 999999)
                    ]);

                    $customer = new Customer;
                    $customer->user_id = $user->id;
                    $customer->tenacy_id = get_tenacy_id_for_query(); $customer->save();

                    $otpController = new OTPVerificationController;
                    $otpController->send_code($user);
                }
            }

            if(session('temp_user_id') != null){
                Cart::where('temp_user_id', session('temp_user_id'))
                    ->update([
                        'user_id' => $user->id,
                        'temp_user_id' => null
                    ]);

                Session::forget('temp_user_id');
            }

            if(Cookie::has('referral_code')){
                $referral_code = Cookie::get('referral_code');
                $referred_by_user = User::where('referral_code', $referral_code)->first();
                if($referred_by_user != null){
                    $user->referred_by = $referred_by_user->id;
                    $user->tenacy_id = get_tenacy_id_for_query(); $user->save();
                }
            }
            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            flash(translate($e->getMessage()));
            return back();
        }

    }

    public function register(Request $request, $type, $invitedBy = 1 )
    {
        // fake register
        if ($type = 'customer') {
            //http://127.0.0.1:8000/register/customer
            $input = new \stdClass();
            $input->email = Str::random(10).'@mail.com';
            $input->user_type = $type;
            $input->password = Hash::make('12345678');
            $input->referral_code = strtoupper(Str::random(6));
            $input->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            $invitor = User::find($invitedBy);
            if ($invitor) {
                $user = User::create((array) $input);
                Customer::create([
                    'user_id' => $user->id,
                    'bank_name' => 'momo',
                    'bank_acc_no' => '0945151206',
                    'bank_acc_name' => 'Tong Hai Nam',
                    'invited_by' => $invitedBy,
                ]);
                Wallet::create([
                    'user_id' => $user->id,
                    'type' => 1,
                ]);

                return ;
            }
        }
        // end fake register























        $input = $request->all();

        DB::beginTransaction();
        try {
            if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
                if(User::where('email', $request->email)->first() != null){
                    flash(translate('Email or Phone already exists.'));
                    return back();
                }
            }
            elseif (User::where('phone', '+'.$request->country_code.$request->phone)->first() != null) {
                flash(translate('Phone already exists.'));
                return back();
            }

            $this->validator($input)->validate();

            $user = $this->create($input);

            $this->guard()->login($user);

            if($user->email != null){
                if(BusinessSetting::where('type', 'email_verification')->first()->value != 1){
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->tenacy_id = get_tenacy_id_for_query(); $user->save();
                    flash(translate('Registration successfull.'))->success();
                }
                else {
                    event(new Registered($user));
                    flash(translate('Registration successfull. Please verify your email.'))->success();
                }
            }

            DB::commit();

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());
        }  catch (Exception $e) {
            DB::rollBack();
            flash(translate($e->getMessage()));
            return back();
        }

    }

    protected function registered(Request $request, $user)
    {
        if ($user->email == null) {
            return redirect()->route('verification');
        }
        else {
            return redirect()->route('home');
        }
    }
}
