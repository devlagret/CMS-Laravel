<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
    protected $table = 'branches';

    protected $primaryKey = 'branch_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'branch_id', 'branch_name', 'leader_name', 'contact', 'address', 'user_id', 'warehouse_id'
    ];
}
