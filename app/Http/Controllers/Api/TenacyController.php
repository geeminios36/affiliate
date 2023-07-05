<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Upload;
use App\Customer;
use App\Order;
use App\User;

class TenacyController extends Controller
{
    public function getInfoSiteByTenacy(Request $request)
    {
        $tenacy_id = get_tenacy_id_for_query();
        $products = Product::where('tenacy_id', $tenacy_id)->count();
        $categories = Category::where('tenacy_id', $tenacy_id)->count();
        $images = Upload::where('tenacy_id', $tenacy_id);
        $totalImages = $images->count();
        $sizeImages = number_format($images->sum('file_size') / 1048576, 2) . ' MB';
        $customers = Customer::where('tenacy_id', $tenacy_id)->count();
        $orders = Order::where('tenacy_id', $tenacy_id)->count();
        $users = User::where('tenacy_id', $tenacy_id)->count();
        return response()->json([
            'success' => true,
            'total_products' => $products,
            'total_categories' => $categories,
            'total_images' => $totalImages,
            'total_size_images' => $sizeImages,
            'total_customers' => $customers,
            'total_orders' => $orders,
            'total_users' => $users,
            'message' => null
        ]);
    }
    
}
