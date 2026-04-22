<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    use HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        // 'status',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
    public function role(){
        return $this->belongsTo(Role::class , 'role_id');
    }
    public function categories(){
        return $this->hasMany(Category::class , 'admin_id' , 'id');
    }
    public function products(){
        return $this->belongsToMany(Product::class , 'carts' , 'user_id' , 'product_id');
    }
    // one to many relationship (user - order)
    public function orders(){
        return $this->hasMany(Order::class ,'user_id' , 'id');
    }
    public function VendorProducts(){
        return $this->hasMany(Product::class , 'vendor_id' , 'id');
    }
}
