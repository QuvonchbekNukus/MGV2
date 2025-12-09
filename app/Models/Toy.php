<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\LogsActivity;

class Toy extends Model
{
    use HasFactory, LogsActivity;

    protected $primaryKey = 'id_toy';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'code',
        'made_at',
        'made_in',
        'type',
        'description',
        'id_user',
    ];

    /**
     * Qurol tegishli user (mas'ul)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
