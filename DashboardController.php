<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Menu;
use App\Models\Chef;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $user = User::count('id');
        $menu = Menu::count('id');
        $chef = Chef::count('id');
        $a = Reservasi::all();
        return view('admin.index' ,compact('menu','chef','user','a'));
    }
}
