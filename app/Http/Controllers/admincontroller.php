<?php

namespace App\Http\Controllers;

use App\Stock;
use App\MasterItem;
use App\MasterLocation;
use App\Transaction;
use App\Um;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class admincontroller extends Controller
{
    public function index(){
        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    //Menampilkan Halaman Stock, Halaman ini ketika pertama kali Login akan di tampilkan
    public function stockBarang(){
        $data = Stock::all();
        $location = MasterLocation::all();
        $item  =   MasterItem::all();
    
        
        return view('stock',[
            'data' => $data,
            'location' => $location,
            'item' => $item
        ]);
    }

}
