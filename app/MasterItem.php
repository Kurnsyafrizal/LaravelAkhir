<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterItem extends Model
{
    //mendefinisikan table yang dituju secara jelas
    protected $table = "master_items";

    //melakukan relationship pada tabel ums
    public function um()
    {   
        //hasOne atau relation one to one
        return $this->hasOne('App\Um','id', 'um_id');
    }
}
