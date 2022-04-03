<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Transaction;

class TransactionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $column = '', $search = ''; 
    public function __construct($column, $search){
        $this->column = $column;
        $this->search = $search;
    }

    public function collection()
    {
        if($this->column === '' && $this->search === ''){
            return Transaction::all();
        }else{
            return Transaction::where($this->column, 'LIKE', '%'.$this->search.'%')->get();
        }
    }
}
