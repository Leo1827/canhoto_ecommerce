<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TermAcceptance extends Model
{
    //
    use HasFactory;

    protected $table = 'term_acceptances';

    protected $fillable = [
        'user_id',
        'accepted_at',
        'ip_address',
        'terms_version',
    ];

    protected $dates = [
        'accepted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
