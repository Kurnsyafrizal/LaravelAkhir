<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //mendefinisikan table yang dituju secara jelas
    protected $table = "transactions";

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

    //melakukan relationship pada tabel user
    public function user()
    {
        //hasOne atau relation one to one
        return $this->hasOne(User::class,'id', 'user_id');
    }
}
