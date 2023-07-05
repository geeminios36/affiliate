<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserCollection;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function info($id)
    {
        return new UserCollection(User::where('id', $id)->get());
    }

    public function updateName(Request $request)
    {
        $user = User::where('id', $request->user_id)
                    ->update([
                        'name' => $request->name
                    ]);
        return response()->json([
            'message' => 'Profile information has been updated successfully'
        ]);
    }
}
