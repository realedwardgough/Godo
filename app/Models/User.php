<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /**
     * Connection of a user to all their lists
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lists() {
        return $this->hasMany(Lists::class);
    }
}
