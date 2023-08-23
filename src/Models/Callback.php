<?php

namespace BaSalam\Auth\Models;

use Illuminate\Database\Eloquent\Model;

class Callback extends Model
{
    protected $table = "callbacks";
    protected $fillable = ["user_id", "data"];

}
