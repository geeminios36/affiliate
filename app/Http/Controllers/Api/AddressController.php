<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AddressCollection;
use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function addresses($id)
    {
        return new AddressCollection(Address::where('user_id', $id)->get());
    }

    public function createShippingAddress(Request $request)
    {
        $address = new Address;
        $address->user_id = $request->user_id;
        $address->address = $request->address;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->tenacy_id = get_tenacy_id_for_query(); $address->save();

        return response()->json([
            'message' => 'Shipping information has been added successfully'
        ]);
    }

    public function deleteShippingAddress($id)
    {
        $address = Address::where('id', $id)->first();
        $address->delete();
        return response()->json([
            'message' => 'Shipping information has been added deleted'
        ]);
    }
}
