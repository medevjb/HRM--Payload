<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model {
    use HasFactory;
    protected $fillable = ['firstName', 'lastName', 'email', 'mobile','role', 'password', 'otp'];
    
    protected $attributes = [
        'otp' => '0',
    ];

    public function UserDetail() {
        return $this->hasOne( UserDetails::class );
    }
}
