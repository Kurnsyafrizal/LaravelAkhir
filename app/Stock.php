<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    // menghapus data sementara
    use softDeletes;

    //mendefinisikan table yang dituju secara jelas
    protected $table = "stoks";

    protected $fillable = ['location_id','item_id','saldo','transaction_date'];

    //melakukan relationship pada tabel item
    public function item()
    {   
         //hasOne atau relation one to one
         return $this->hasOne('App\MasterItem','id', 'item_id');
    }

    //melakukan relationship pada tabel location
    public function location()
    {
        //hasOne atau relation one to one
        return $this->hasOne('App\MasterLocation','id', 'location_id');
    }

}
