<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class RestaurantController extends Controller
{
    public function AllMenu(){
        $menu = Menu::latest()->get();
        return view('client.backend.menu.all_menu', compact('menu'));
    }
    public function AddMenu(){
        return view('client.backend.menu.add_menu');
    }

    public function StoreMenu(Request $request)
    {

        if ($request->file('image')) {
            $image = $request->file('image');
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $img = $manager->read($image);
            $img->resize(300, 300)->save(public_path('upload/menu/' . $name_gen));
            $save_url = 'upload/menu/' . $name_gen;

            Menu::create([
                'menu_name' => $request->menu_name,
                'image' => $save_url,
            ]);
        }

        $notification = array(
            'message' => 'Menu Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('all.menu')->with($notification);
    }
    // End Method
}
