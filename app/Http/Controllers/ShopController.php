<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shop;
use App\User;
use App\Seller;
use App\BusinessSetting;
use App\Models\Category;
use App\Models\Product;
use Auth;
use Hash;
use App\Notifications\EmailVerificationNotification;

class ShopController extends Controller
{

    public function __construct()
    {
        $this->middleware('user', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user()->shop;
        return view('frontend1.user.seller.shop', compact('shop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->user_type == 'admin') {
            flash(translate('Admin can not be a seller'))->error();
            return back();
        } else {
            return view('frontend.seller_form');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = null;
        if (!Auth::check()) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email already exists!'))->error();
                return back();
            }
            if ($request->password == $request->password_confirmation) {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->user_type = "seller";
                $user->password = Hash::make($request->password);
                $user->tenacy_id = get_tenacy_id_for_query();
                $user->save();
            } else {
                flash(translate('Sorry! Password did not match.'))->error();
                return back();
            }
        } else {
            $user = Auth::user();
            if ($user->customer != null) {
                $user->customer->delete();
            }
            $user->user_type = "seller";
            $user->tenacy_id = get_tenacy_id_for_query();
            $user->save();
        }

        $seller = new Seller;
        $seller->user_id = $user->id;
        $seller->tenacy_id = get_tenacy_id_for_query();
        $seller->save();

        if (Shop::where('user_id', $user->id)->first() == null) {
            $shop = new Shop;
            $shop->user_id = $user->id;
            $shop->name = $request->name;
            $shop->address = $request->address;
            $shop->slug = preg_replace('/\s+/', '-', $request->name) . '-' . $shop->id;
            $shop->tenacy_id = get_tenacy_id_for_query();
            if ($shop->save()) {
                auth()->login($user, false);
                if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->tenacy_id = get_tenacy_id_for_query();
                    $user->save();
                } else {
                    $user->notify(new EmailVerificationNotification());
                }

                flash(translate('Your Shop has been created successfully!'))->success();
                return redirect()->route('shops.index');
            } else {
                $seller->delete();
                $user->user_type == 'customer';
                $user->tenacy_id = get_tenacy_id_for_query();
                $user->save();
            }
        }

        flash(translate('Sorry! Something went wrong.'))->error();
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
        //
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
        $shop = Shop::where('id', $id)->first();

        if ($request->has('name') && $request->has('address')) {
            $shop->name = $request->name;
            if ($request->has('shipping_cost')) {
                $shop->shipping_cost = $request->shipping_cost;
            }
            $shop->address = $request->address;
            $shop->phone = $request->phone;
            $shop->slug = preg_replace('/\s+/', '-', $request->name) . '-' . $shop->id;

            $shop->meta_title = $request->meta_title;
            $shop->meta_description = $request->meta_description;
            $shop->logo = $request->logo;

            if ($request->has('pick_up_point_id')) {
                $shop->pick_up_point_id = json_encode($request->pick_up_point_id);
            } else {
                $shop->pick_up_point_id = json_encode(array());
            }
        } elseif ($request->has('facebook') || $request->has('google') || $request->has('twitter') || $request->has('youtube') || $request->has('instagram')) {
            $shop->facebook = $request->facebook;
            $shop->google = $request->google;
            $shop->twitter = $request->twitter;
            $shop->youtube = $request->youtube;
        } else {
            $shop->sliders = $request->sliders;
        }
        $shop->tenacy_id = get_tenacy_id_for_query();
        if ($shop->save()) {
            flash(translate('Your Shop has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
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
        //
    }

    public function verify_form(Request $request)
    {
        if (Auth::user()->seller->verification_info == null) {
            $shop = Auth::user()->shop;
            return view('frontend.user.seller.verify_form', compact('shop'));
        } else {
            flash(translate('Sorry! You have sent verification request already.'))->error();
            return back();
        }
    }

    public function verify_form_store(Request $request)
    {
        $data = array();
        $i = 0;
        foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
            $item = array();
            if ($element->type == 'text') {
                $item['type'] = 'text';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'select' || $element->type == 'radio') {
                $item['type'] = 'select';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'multi_select') {
                $item['type'] = 'multi_select';
                $item['label'] = $element->label;
                $item['value'] = json_encode($request['element_' . $i]);
            } elseif ($element->type == 'file') {
                $item['type'] = 'file';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i]->store('uploads/verification_form');
            }
            array_push($data, $item);
            $i++;
        }
        $seller = Auth::user()->seller;
        $seller->verification_info = json_encode($data);
        $seller->tenacy_id = get_tenacy_id_for_query();
        if ($seller->save()) {
            flash(translate('Your shop verification request has been submitted successfully!'))->success();
            return redirect()->route('dashboard');
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function shop_detail()
    {
        $categories = Category::all(['id', 'name']);
        return view('frontend.shop.detail', compact('categories'));
    }

    public function show_products(Request $request)
    {

        try {
            $products = Product::where('user_id', 9);;
            $search = $request->getQueryString();
            if ($request->query('sort_by')) {
                $products =  $products->orderBy($request->query('sort_by'), $request->query('key'));
            }
            if ($request->query('categories')) {
                $products = $this->filterByCategoryId($products, $request->query('categories'));
            }
            if ($request->query('unit_price')) {
                $numbers = preg_split('/[\s,-]+/', $request->query('unit_price'));
                $products = $this->filterByUnitPrice($products, $numbers);
            }


            return view('frontend.shop.columns.products', compact('products'))->render();
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function filterByUnitPrice($product, $values)
    {
        if (count($values) > 1) {
            $max = max($values);
            $min = min($values);
            $values = [$min, $max];
        }

        if (count($values) == 2) {
            $product = $product->where('unit_price', '>=', $values[0])->where('unit_price', '<=', $values[1]);
        } else {
            $product = $product->where('unit_price', '>=', $values[0]);
        }
        return  $product;
    }

    public function filterByCategoryId($products, $value)
    {
        return $products->whereIn('category_id', explode('%2C', $value[0]));
    }
    public function filter_product_shop(Request $request)
    {

        $body = $request->all();
        $products = Product::where('user_id', 9)->orderBy($body['column'], $body['value']);

        return response()->json(['success' => true, 'view' =>  view('frontend.shop.columns.products', compact('products'))->render()]);
    }
}
