<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pod extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'pods';

    protected $fillable = [
        'id',
        'pc_id',
        'member_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
