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

    //melakukan relationship pada tabel item
    public function item()
    {   
         //hasOne atau relation one to one
         return $this->hasOne(MasterItem::class,'id', 'item_id');
    }

    //melakukan relationship pada tabel location
    public function location()
    {
        //hasOne atau relation one to one
        return $this->hasOne(MasterLocation::class,'id', 'location_id');
    }

}
