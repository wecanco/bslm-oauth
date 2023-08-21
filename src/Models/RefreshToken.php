<?php

namespace BaSalam\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{

    protected $fillable = [
        'token',
        'refresh_token',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
