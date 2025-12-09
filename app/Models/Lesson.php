<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class Lesson extends Model
{
    use HasFactory, LogsActivity;

    protected $primaryKey = 'id_lesson';
    protected $guarded = [];

    protected $fillable = [
        'topic',
        'id_group',
        'id_user',
        'lesson_date',
        'lesson_duration',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'lesson_date' => 'date',
    ];

    /**
     * Dars tegishli guruh
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'id_group', 'id_group');
    }

    /**
     * Dars tegishli instructor
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
