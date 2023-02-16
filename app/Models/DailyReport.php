<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'daily_report';

    protected $primaryKey = 'file_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'file_id', 'path', 'name', 'branch_id',
    ];
}
