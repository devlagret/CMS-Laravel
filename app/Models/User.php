<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
       'uuid',
       'username',
       'name',
       'full_name',
       'contact',
       'email',
       'password',
       'role_id',
       'remember_token',
       'email_verified_at',
       'created_id',
       'updated_id',
       'deleted_id',
       'user_level',
       'user_token',
       'adrress',
       'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function logs()
    {
        return $this->hasMany(Log::class, 'user_id');
    }
    public function branch()
    {
        return $this->hasOne(Branch::class, 'user_id');
    }
    public function warehouse()
    {
        return $this->hasOne(WhsDetail::class, 'user_id');
    }
    protected static function booted(): void
    {
        static::created(function (User $user) {
            if(empty( $user->uuid)){
                $user->uuid = Str::uuid();
            }
        });
    }
}
