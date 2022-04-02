<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class StockExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Stock::all();
        return view('stock_print',['data'=>$data]);
    }
}
