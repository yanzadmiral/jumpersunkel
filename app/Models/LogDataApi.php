<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogDataApi extends Model
{
    use HasFactory;
    protected $fillable = ['str_unix','raw_request','raw_respons'];
}
