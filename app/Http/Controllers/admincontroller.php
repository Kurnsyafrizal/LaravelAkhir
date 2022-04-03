<?php

namespace App\Http\Controllers;

use App\Stock;
use App\MasterItem;
use App\MasterLocation;
use App\Transaction;
use App\Um;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
    public function HalamanHome(){
        return view('HalamanUtama');
    }


    //Filter
    public function stockfilter($id,Request $request){
        $data = [];
        //Membuat Object
        $place0 = ['value' => '0', 'label' =>'Tanpa Filter'];
        $obj0 = (object) $place0;
        $place1 = ['value' => '1', 'label' =>'Kode Barang', 'column' => 'item_id'];
        $obj1 = (object) $place1;
        $place2 = ['value' => '2', 'label' =>'Lokasi', 'column' => 'location_id'];
        $obj2 = (object) $place2;

        //Membuat Array Penammpung
        $filter = array($obj0 ,$obj1, $obj2);

        if(!empty($request->all()) && $request->get('filter') != 0){
            $getParamFilter = $request->get('filter');
            $searchData = $filter[array_search($getParamFilter, array_column($filter, 'value'))];
            $getParamSearch = $request->get(str_replace(' ', '_', strtolower($searchData->label)));
            $data = Stock::where($searchData->column, 'LIKE', '%'.$getParamSearch.'%')->get();
        }else{
            $data = Stock::all();
        }

        $location = MasterLocation::all();
        $item = MasterItem::all();

        return view('stock/{id}',[
            'data' => $data,
            'location' => $location,
            'item' => $item,
            'filter'=> $filter,
            'id' => $id
        ]);
    }

    //Halaman Add Stock 
    public function addStock(){

        $ums = Um::all();
        $location = MasterLocation::all();
        $item  =   MasterItem::all();


        return view('addstock',[
            'ums' => $ums,
            'location' => $location,
            'item' => $item
        ]);
    }


    // ========================= RECEIPT ========================
    //Menerima Barang
    public function receipt(Request $request){
        $cekData = DB::table('transactions')->where('item_id', $request->kode_barang)->orderBy('tgl_transaksi', 'DESC')->first();
        // if(!empty($cekData) && (strtotime(Carbon::now()->format('Y-m-d')) <= Carbon::parse($cekData->tgl_transaksi)->format('Y-m-d'))){
        //     dd('Data sudah pernah di input');
        //     return redirect()->back();
        // }


        $stock = Stock::where([
            ['item_id','like',$request->kode_barang], 
            ['location_id','like',$request->location]])->first();

        if($stock==null || !empty($cekData) && (strtotime(Carbon::now()->format('Y-m-d')) <= Carbon::parse($cekData->tgl_transaksi)->format('Y-m-d')))
        {
            Stock::create([
                [
                'location_id'=> $request->id, 
                'item_id'=> $request->kode_barang, 
                'saldo'=> $request->qty, 
                'transaction_date'=> Carbon::now(),
                'created_at'=> Carbon::now()],
            ]);
        }
        else
        {
            $stock->saldo = $stock->saldo+$request->qty;
            $stock->save();
        }

        
        DB::table('transactions')->insert([
            [
            'bukti'=> 'TAMBAH'.sprintf("%02d", Transaction::where('program', '=', 'RECEIPT')->get()->count() + 1 ),
            'tgl_transaksi'=> Carbon::now(), 
            'location_id'=> $request->location, 
            'item_id'=> $request->kode_barang, 
            'qty'=> $request->qty, 
            'program'=>'RECEIPT', 
            'user_id'=> Auth::user()->id ,
            'created_at'=> Carbon::now()
            ]
        ]);

        return redirect('/stock');

    }

    // ================================= ISSUE PAGE =============================
    //Halaman Issue
    public function issuePage(){

        $location   = MasterLocation::all();
        $item       = MasterItem::all();
        $ums        = Um::all();

        return view('issue',[
            'ums' => $ums,
            'location' => $location,
            'item' => $item
        ]);
    }

    public function issue(){

    }


    
    //Get Id Master Item
    public function getItem($id)
    {
        $data = MasterItem::find($id);
        return $data;
    }



    // =============================== TRANSACTION ==============================

    //Halaman Transaction
    public function transaction($id, Request $request){
        $data = [];
        //Membuat Object
        $place0 = ['value' => '0', 'label' =>'Tanpa Filter'];
        $obj0 = (object) $place0;
        $place1 = ['value' => '1', 'label' =>'Bukti', 'column' => 'bukti'];
        $obj1 = (object) $place1;
        $place2 = ['value' => '2', 'label' =>'Lokasi', 'column' => 'location_id'];
        $obj2 = (object) $place2;
        $place3 = ['value' => '3', 'label' =>'Kode Barang', 'column' => 'item_id'];
        $obj3 = (object) $place3;
        $place4 = ['value' => '4', 'label' =>'Tanggal', 'column' => 'tgl_transaksi'];
        $obj4 = (object) $place4;

        //Membuat Array Penammpung
        $filter = array($obj0 ,$obj1, $obj2, $obj3, $obj4);

        if(!empty($request->all()) && $request->get('filter') != 0){
            $getParamFilter = $request->get('filter');
            $searchData = $filter[array_search($getParamFilter, array_column($filter, 'value'))];
            $getParamSearch = $request->get(str_replace(' ', '_', strtolower($searchData->label)));
            $data = Transaction::where($searchData->column, 'LIKE', '%'.$getParamSearch.'%')->get();
        }else{
            $data = Transaction::all();
        }

        $location = MasterLocation::all();
        $item = MasterItem::all();

        return view('transaction',[
            'data' => $data,
            'location' => $location,
            'item' => $item,
            'filter'=> $filter,
            'id' => $id
        ]);
    }
    

}
