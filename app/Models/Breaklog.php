<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Breaklog extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'break_logs';

    protected $fillable = [
        'id',
        'attendance_id',
        'break_start',
        'break_end'
    ];

    /**
     * Get the attendance that owns the Breaklog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attendance() {
        return $this->belongsTo(Attendance::class);
    }
}
