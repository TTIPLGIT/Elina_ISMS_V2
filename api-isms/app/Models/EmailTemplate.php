<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;
    protected $table = 'email_preview';
    protected $fillable = [
        'screen',
        'email_subject',
        'email_body',
        'active_flag',
    ];
}
