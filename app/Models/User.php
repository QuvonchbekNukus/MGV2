<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\LogsActivity;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'address',
        'is_active',
        'last_login_at',
        'second_name',
        'third_name',
        'jinsi',
        'rank',
        'job_title',
        'job_responsibility',
        'is_married',
        'degree',
        'passport_seria',
        'passport_code',
        'height',
        'weight',
        'license_code',
        'id_group',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_married' => 'boolean',
        ];
    }

    /**
     * User tegishli guruh
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'id_group', 'id_group');
    }

    /**
     * Foydalanuvchi o'tkazgan darslar
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'id_user', 'id');
    }

    /**
     * Foydalanuvchiga biriktirilgan qurollar
     */
    public function toys()
    {
        return $this->hasMany(Toy::class, 'id_user', 'id');
    }

    /**
     * Foydalanuvchi faolmi?
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * Oxirgi kirish vaqtini yangilash (LogsActivity event-ni trigger qilmasin)
     */
    public function updateLastLogin(): void
    {
        $this->withoutEvents(function () {
            $this->update(['last_login_at' => now()]);
        });
    }
}
