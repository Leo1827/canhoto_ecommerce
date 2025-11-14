<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    protected $fillable = [
        'site_name',
        'logo',
        'favicon',
        'email_contacto',
        'telefono_contacto',
        'modo_oscuro',
    ];
}
