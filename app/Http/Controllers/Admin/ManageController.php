<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Menu;
use App\Models\Product;
use App\Models\City;
use App\Models\Client;
use App\Models\Gllery;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class ManageController extends Controller
{
    public function AdminAllProduct()
    {
        $product = Product::orderBy('id', 'desc')->get();
        return view('admin.backend.product.all_product', compact('product'));
    }
    // End Method

    public function AdminAddProduct()
    {
        $category = Category::latest()->get();
        $city = City::latest()->get();
        $menu = Menu::latest()->get();
        $client = Client::latest()->get();
        return view('admin.backend.product.add_product', compact('category', 'city', 'menu', 'client'));
    }
    // End Method
}
