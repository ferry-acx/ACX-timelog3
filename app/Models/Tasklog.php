<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tasklog extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'task_logs';

    protected $fillable = [
        'id',
        'attendance_id',
        'project',
        'tasks'
    ];

    /**
     * Get the attendancce that owns the Tasklog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attendance() {
        return $this->belongsTo(Attendance::class);
    }
}
