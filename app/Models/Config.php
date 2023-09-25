<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Config extends Model
{
    use Notifiable, HasFactory;

    protected $table = 'configs';

    protected $fillable = [
        'id',
        'name',
        'value'
    ];
}
