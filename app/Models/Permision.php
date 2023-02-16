<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permision extends Model
{
    //
    public function privileges()
    {
        return $this->hasMany(Privilege::class,'permision_id');
    }
    protected $table = 'permisions';
    protected $primaryKey = 'permision_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'permision_id','name','label','group'
    ];
}
