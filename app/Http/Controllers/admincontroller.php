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

    // Filter Stock
    public function stockFilter(Request $request)
    {
        $loc = MasterLocation::all();
        $item = MasterItem::all();
        $data = Stock::where([
            ['item_id','like',$request->kode_barang], 
            ['location_id','like',$request->location]])->get();

        return view('stock',[
            'data'=>$data,
            'loc'=>$loc,
            'item'=>$item
        ]);
    }



    //Halaman Add Stock 
    public function addStock(){

        $ums = Um::all();
        $location = MasterLocation::all();
        $item  =   MasterItem::all();

        $data = Transaction::where('program','like', 'RECEIPT')->latest('created_at')->first();
        
        //mengecek kondisi ketika ada Receipt atau tidak
        // kalau tidak dia akan mulai dari 1
        if($data == NULL){
            $count = 1;
        }
        else{
            //kalau ada dia akan mulai angka selanjutnya
            $dats = $data->bukti;
            $dats = str_replace("TAMBAH", "", $dats);
            $count = $dats+1;

        }


        return view('addstock',[
            'count'=> $count,
            'ums' => $ums,
            'location' => $location,
            'item' => $item
        ]);
    }

    //Menerima Barang
    public function receipt(Request $request){

        DB::table('transactions')->insert([
            [
                'transaction_date'=>Carbon::now(), 
                'proof'=>$request->proof,
                'location_id'=>$request->location, 
                'item_id'=>$request->part, 
                'qty'=>$request->qty, 
                'program'=>'RECEIPT', 
                'user_id'=>Auth::user()->id ,
                'created_at'=>Carbon::now()
            ]
        ]);

        //CEK DI STOK, KALAU ADA EDIT, KALAU TDK ADA INSERT LALU REDIRECT KE STOCK
        $now = Carbon::parse(Carbon::now())->format('Y-m-d');
        $stock = Stock::where([['transaction_date','like',$now."%"], ['item_id','like',$request->part], ['location_id','like',$request->location]])->first();
        if($stock->id==null)
        {
            DB::table('stocks')->insert([
                ['location_id'=>$request->id, 
                'item_id'=>$request->part, 
                'stored'=>$request->qty, 
                'transaction_date'=>Carbon::now(),
                'created_at'=>Carbon::now()],
            ]);
        }
        else
        {
            $stock->stored = $stock->stored+$request->qty;
            $stock->save();
        }

        return redirect('/stock');

    }


    //Halaman Issue
    public function issuePage(){

        $location   = MasterLocation::all();
        $item       = MasterItem::all();
        $ums        = Um::all();

        $data = Transaction::where('program','like', 'ISSUE')->latest('created_at')->first();

        if($data == NULL){
            $count = 1;
        }
        else{
            $dats = $data->bukti;
            $dats = str_replace("KURANG", "", $dats);
            $count = $dats+1;
        }

        return view('issue',[
            'count'=> $count,
            'ums' => $ums,
            'location' => $location,
            'item' => $item
        ]);
    }

    //Halaman Transaction
    public function transaction($id){
        
        $data = Transaction::all();
        $location = MasterLocation::all();
        $item = MasterItem::all();
        
        //Membuat Object
        $place0 = ['value' => '0', 'label' =>'Tanpa Filter'];
        $obj0 = (object) $place0;
        $place1 = ['value' => '1', 'label' =>'bukti'];
        $obj1 = (object) $place1;
        $place2 = ['value' => '2', 'label' =>'lokasi'];
        $obj2 = (object) $place2;
        $place3 = ['value' => '3', 'label' =>'kode_barang'];
        $obj3 = (object) $place3;
        $place4 = ['value' => '4', 'label' =>'Tanggal'];
        $obj4 = (object) $place4;

        //Membuat Array Penammpung
        $filter = array($obj0 ,$obj1, $obj2, $obj3, $obj4);

        return view('transaction',[
            'data' => $data,
            'location' => $location,
            'item' => $item,
            'filter'=> $filter,
            'id' => $id
        ]);
    }
    

    // Transaction Filter
    public function transactionFilter(Request $request)
    {
        $data = Transaction::where([
            ['item_id','like',$request->kode_barang], 
            ['location_id','like',$request->location], 
            ['tgl_transaksi','like',$request->date.'%'], 
            ['bukti','like',$request->bukti.'%']])->get();
        
        $location = MasterLocation::all();
        $item = MasterItem::all();
        
        return view('transaction',[
            'data'=>$data,
            'location'=>$location,
            'item'=>$item]);
    }

}
