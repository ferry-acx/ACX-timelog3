<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Attendance extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'user_id',
        'time_in',
        'time_out',
        'goal_tasks',
        'location',
        'status',
        'assessment'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function breaklogs(){
        return $this->hasMany(Breaklog::class);
    }

    public function tasklogs(){
        return $this->hasMany(Tasklog::class);
    }
}
