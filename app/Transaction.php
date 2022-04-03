<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //mendefinisikan table yang dituju secara jelas
    // protected $table = "transactions";

    protected $fillable = [
        'bukti', 'tgl_transaksi','location_id','item_id','qty','program','user_id'
    ];

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

    //melakukan relationship pada tabel user
    public function user()
    {
        //hasOne atau relation one to one
        return $this->hasOne('App\User','id', 'user_id');
    }
}
