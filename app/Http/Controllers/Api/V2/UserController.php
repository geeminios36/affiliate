<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\UserCollection;
use App\User;
use Illuminate\Http\Request;
use Lcobucci\JWT\Parser;
use Illuminate\Support\Facades\Validator;
use DB;
use Hash;

class UserController extends Controller
{
    public function info($id)
    {
        return new UserCollection(User::where('id', $id)->get());
    }

    public function updateName(Request $request)
    {
        $user = User::where('id',$request->user_id)
                    ->update([
                        'name' => $request->name
                    ]);
        return response()->json([
            'message' => 'Profile information has been updated successfully'
        ]);
    }

    public function getUserInfoByAccessToken(Request $request)
    {
        //$token = $request->bearerToken();
        $token = $request->access_token;

        $false_response = [
            'result' => false,
            'id' => 0,
            'name' => "",
            'email' => "",
            'avatar' => "",
            'avatar_original' => "",
            'phone' => ""
        ];

        if($token == "" || $token == null){
            return response()->json($false_response);
        }

        try {
            $token_id = (new Parser())->parse($token)->getClaims()['jti']->getValue();
        } catch (\Exception $e) {
            return response()->json($false_response);
        }

        $oauth_access_token_data =  DB::table('oauth_access_tokens')->where('id', '=', $token_id)->first();

        if($oauth_access_token_data == null){
            return response()->json($false_response);
        }

        $user = User::where('id', $oauth_access_token_data->user_id)->first();

        if ($user == null) {
            return response()->json($false_response);

        }

        return response()->json([
            'result' => true,
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'avatar_original' => api_asset($user->avatar_original),
            'phone' => $user->phone
        ]);

    }

    public function updateUserByTenacyId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:191',
            'password' => 'required|string|min:6|max:191',
            'tenacy_id' => 'required|string|max:191',
        ]);
       
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'data' => null,
                'status' => 422
            ], 422);
        }
        $user = User::where('tenacy_id', $request->tenacy_id)->where('user_type', 'admin');
        if(empty($user->first())) {
            return response()->json([
                'errors' => 'Data not found',
                'data' => null,
                'status' => 404
            ], 404);
        }

        DB::beginTransaction();
        try {
            $user->update([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            DB::commit();
            return response()->json([
                'errors' => null,
                'data' => null,
                'status' => 200,
                'message' => 'Profile information has been updated successfully'
            ], 200);   

        }catch (\Throwable $e){
            DB::rollBack();
            return response()->json([
                'errors' => $e->getMessage(),
                'data' => null,
                'status' => 422
            ], 422);    
        }
    }
}
