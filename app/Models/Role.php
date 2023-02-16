<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    public function privileges()
    {
       return $this->hasMany(Privilege::class,'role_id');
    }
    public function permissions()
    {
        $permision = $this->privileges;
        return $permision->permisions;
    }
    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
       'role_id','name'
    ];
}
