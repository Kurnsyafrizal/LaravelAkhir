<?php

namespace App\Http\Controllers;

use App\Exports\StockExport;
use App\Exports\TransactionExport;
use App\Transaction;
use App\Stock;
use App\Http\Controllers\MasterLocation;
use App\Http\Controllers\MasterItem;
use Illuminate\Http\Request;
use PDF;
use Excel;

class ExportController extends Controller
{
    /// Stock Excel
    public function stockexcelExport($params, Request $request){
         //Mengkodekan data Params
        $parse = json_decode(base64_decode($params));

        //Membuat Object
        $place0 = ['value' => '0', 'label' =>'Tanpa Filter'];
        $obj0 = (object) $place0;
        $place1 = ['value' => '1', 'label' =>'Kode Barang', 'column' => 'item_id'];
        $obj1 = (object) $place1;
        $place2 = ['value' => '2', 'label' =>'Lokasi', 'column' => 'location_id'];
        $obj2 = (object) $place2;

        //Membuat Array Penammpung objek yang di buat
        $filter = array($obj0 ,$obj1, $obj2);

        //
        if(!empty($parse) && $parse->filter != 0){
            $getParamFilter = $parse->filter;

            // mencari data didalam arrray get
            $searchData = $filter[array_search($getParamFilter, array_column($filter, 'value'))];
            $get = str_replace(' ', '_', strtolower($searchData->label));
            $column = $searchData->column;
            $getParamSearch = $parse->{$get};
        }else{
            $column = '';
            $getParamSearch = '';
        }

        $nama_file = 'Stock.xlsx';
        return Excel::download(new StockExport($column, $getParamSearch), $nama_file);
    }



    /// Transaction Excel

    public function excelExport($params, Request $request){
        $parse = json_decode(base64_decode($params));
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
        if(!empty($parse) && $parse->filter != 0){
            //menampung params
            $getParamFilter = $parse->filter;

            // melakukan search aray 
            $searchData = $filter[array_search($getParamFilter, array_column($filter, 'value'))];
            $get = str_replace(' ', '_', strtolower($searchData->label));
            $column = $searchData->column;
            $getParamSearch = $parse->{$get};
        }else{
            $column = '';
            $getParamSearch = '';
        }

        $nama_file = 'Transaksi.xlsx';
        return Excel::download(new TransactionExport($column, $getParamSearch), $nama_file);
    }


    

    //Stock PDF
    public function stockexportPDF($params, Request $request){

        //Mengkodekan data Params
        $parse = json_decode(base64_decode($params));

        //Membuat Object untuk pilihan filter
        $place0 = ['value' => '0', 'label' =>'Tanpa Filter'];
        $obj0 = (object) $place0;
        $place1 = ['value' => '1', 'label' =>'Kode Barang', 'column' => 'item_id'];
        $obj1 = (object) $place1;
        $place2 = ['value' => '2', 'label' =>'Lokasi', 'column' => 'location_id'];
        $obj2 = (object) $place2;


        //Membuat Array Penammpung objek yang di buat
        $filter = array($obj0 ,$obj1, $obj2);

        if(!empty($parse) && $parse->filter != 0){
            $getParamFilter = $parse->filter;
            $searchData = $filter[array_search($getParamFilter, array_column($filter, 'value'))];
            $get = str_replace(' ', '_', strtolower($searchData->label));
            $column = $searchData->column;
            $getParamSearch = $parse->{$get};

            $data = Stock::where($searchData->column, 'LIKE', '%'.$getParamSearch.'%')->get();
        }else{
            $column = '';
            $getParamSearch = '';

            $data = Stock::all();
        }

        $pdf = PDF::loadView('stock_print', ['data' => $data]);
        return $pdf->download('Stock.pdf');

    }


    //Transaction PDF
    public function exportPDF($params, Request $request){
        $parse = json_decode(base64_decode($params));
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
        if(!empty($parse) && $parse->filter != 0){
            $getParamFilter = $parse->filter;
            $searchData = $filter[array_search($getParamFilter, array_column($filter, 'value'))];
            $get = str_replace(' ', '_', strtolower($searchData->label));
            $column = $searchData->column;
            $getParamSearch = $parse->{$get};

            $data = Transaction::where($searchData->column, 'LIKE', '%'.$getParamSearch.'%')->get();
        }else{
            $column = '';
            $getParamSearch = '';

            $data = Transaction::all();
        }

        $pdf = PDF::loadView('transaction_print', ['data' => $data]);
        return $pdf->download('transaction.pdf');

    }
}
