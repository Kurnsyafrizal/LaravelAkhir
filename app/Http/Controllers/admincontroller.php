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
        return view('halamanutama');
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
            //ambil request filter inpt user
            $getParamFilter = $request->get('filter');

            //membuat array 1 dimensi 
            //melakukan search parameter filter dan column Item_id yang memiliki value
            $searchData = $filter[array_search($getParamFilter, array_column($filter, 'value'))];

            //membuat request get dari Search Data dengan label dari array $filter
            $getParamSearch = $request->get(str_replace(' ', '_', strtolower($searchData->label)));

            // melakukan search data column dan getParamSearch
            $data = Stock::where($searchData->column, 'LIKE', '%'.$getParamSearch.'%')->get();
        }else{
            // menampilkan seluruh data dari Stock
            $data = Stock::all();
        }

        $location = MasterLocation::all();
        $item = MasterItem::all();

        return view('stock',[
            'data' => $data,
            'location' => $location,
            'item' => $item,
            'filter'=> $filter,
            'id' => $id
        ]);
    }

    //Halaman Add Stock 
    public function addStock(Request $request){
        $ums = Um::all();
        $location = MasterLocation::all();
        $item  =   MasterItem::all();

        return view('addstock',[
            'ums' => $ums,
            'location' => $location,
            'item' => $item,
        ]);
    }


    // ========================= RECEIPT ========================

    // //Menerima Barang
    public function receipt(Request $request){

        $tglmasuk = $request->input('tgl_masuk');

        //mencari data dalam model stock
        $transac = Transaction::where([
            ['item_id','like',$request->kode_barang],
            ['location_id','like',$request->location],
            ['tgl_transaksi','like', Carbon::createFromFormat('Y-m-d',$tglmasuk)->format('Y-m-d')]
            ])->first();
        
        
        // dd($stock);
        //jika datanya kosong masuk kondisi ini
        if($transac == null)
        {
            //mencari data berdasarkan item_id dan Location_id namun di urutkan berdasarkan transaction_date
            $transac = Transaction::where([
                ['item_id','like',$request->kode_barang], 
                ['location_id','like',$request->location]])
            ->orderBy('tgl_transaksi','DESC')->first();
            

            // jika data nya kosong dapat melakukan input
            // atau tgl_masuk lebih besar dari stock transactiondate
            
            if($transac == NULL || Carbon::createFromFormat('Y-m-d H:i:s',$transac->tgl_transaksi)->lt(Carbon::createFromFormat('Y-m-d',$tglmasuk)))
            {
                DB::table('stoks')->insert([
                    [
                    'location_id'=> $request->location, 
                    'item_id'=> $request->kode_barang, 
                    'saldo'=> $request->qty, 
                    'transaction_date'=> Carbon::createFromFormat('Y-m-d',$tglmasuk),
                    'created_at'=> Carbon::now()],
                ]);
            }else{
                return redirect('/stock/addstock')->with("error", "Data yang anda tambahkan gagal, karena tanggal lebih kecil dari transaksi sebelumnya");
            }
        }
        else
        {
            return redirect('/stock/addstock')->with("error", "Data yang anda tambahkan gagal, karena tanggal lebih kecil dari transaksi sebelumnya");
        }

        
        DB::table('transactions')->insert([
            [
            'bukti'=> 'TAMBAH'.sprintf("%02d", Transaction::where('program', '=', 'RECEIPT')->get()->count() + 1 ),
            'tgl_transaksi'=> Carbon::createFromFormat('Y-m-d',$tglmasuk), 
            'location_id'=> $request->location, 
            'item_id'=> $request->kode_barang, 
            'qty'=> $request->qty, 
            'program'=>'RECEIPT', 
            'user_id'=> Auth::user()->id ,
            'created_at'=> Carbon::now()
            ]
        ]);

        return redirect('/stock/addstock')->with("success", "Data Berhasil Ditambahkan");
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

    public function issue(Request $request){
        //insialisasi yang ingin kita lakukan temp = menampung request quantity yang ditentukan
        $temp = $request->qty;

        //mencari data pada table Stock dengan item_id bedasarkan kodebarang atau location berdasarkan location
        $tempStok = Stock::where([['item_id','like',$request->kode_barang], ['location_id','like',$request->location]])->get();

        //membuat totalan data
        $sumStok = $tempStok->sum('saldo');

        //ketika Stok barang lebih sedikit dari request stok 
        if($sumStok<$temp)
        {
            return redirect('/stock/issue')->with('error', "Request Data Melebihi Jumlah Stok");
        }
        else{
            //jika request lebih dari 0 maka
            while($temp>0)
            {
                //Mecari data Stock bedasarkan
                $get_tempStok = Stock::where([['item_id','like',$request->kode_barang], ['location_id','like',$request->location]])->first();
                
                //membuat kondisi ketika Stok lebih besar dari request
                if($get_tempStok->saldo > $temp)
                {
                    $get_tempStok->saldo = $get_tempStok->saldo - $temp;
                    $get_tempStok->save();


                    DB::table('transactions')->insert([
                        [
                        'bukti'=> 'KURANG'.sprintf("%02d", Transaction::where('program', '=', 'ISSUE')->get()->count() + 1 ),
                        'tgl_transaksi'=> Carbon::now(), 
                        'location_id'=> $request->location, 
                        'item_id'=> $request->kode_barang, 
                        'qty'=> ($temp*-1), 
                        'program'=>'ISSUE', 
                        'user_id'=> Auth::user()->id ,
                        'created_at'=> Carbon::now()
                        ]
                    ]);
                    $temp=0;
                }
                else{
                    // jika stok lebih kecil dari request maka hapus data 
                    // dan dilanjutkan ke temp selanjutnya
                    $temp = $temp - $get_tempStok->saldo;

                    DB::table('transactions')->insert([
                        [
                        'bukti'=> 'KURANG'.sprintf("%02d", Transaction::where('program', '=', 'ISSUE')->get()->count() + 1 ),
                        'tgl_transaksi'=> Carbon::now(), 
                        'location_id'=> $request->location, 
                        'item_id'=> $request->kode_barang, 
                        'qty'=> ($get_tempStok->saldo*-1), 
                        'program'=>'ISSUE', 
                        'user_id'=> Auth::user()->id ,
                        'created_at'=> Carbon::now()
                        ]
                    ]);
                    $get_tempStok->delete();
                }

            }
        }
        return redirect('/stock/issue')->with("success", "Stock Barang Berhasil Keluar");
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
