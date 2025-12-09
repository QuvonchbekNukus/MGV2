<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\LogsActivity;

class Group extends Model
{
    use HasFactory, LogsActivity;

    protected $primaryKey = 'id_group';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    /**
     * Guruhga tegishli userlar
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_group', 'id_group');
    }

    /**
     * Guruhga tegishli darslar
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'id_group', 'id_group');
    }
}
