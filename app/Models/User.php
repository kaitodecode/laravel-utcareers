<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'description',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    // Scopes
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    public function scopeApplicants($query)
    {
        return $query->where('role', 'pelamar');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeHRs($query)
    {
        return $query->where('role', 'hr');
    }

    // Accessors
    public function getRoleLabelAttribute()
    {
        $labels = [
            'admin' => 'Administrator',
            'hr' => 'Human Resources',
            'pelamar' => 'Pelamar Kerja'
        ];

        return $labels[$this->role] ?? 'Unknown';
    }

    public function getRoleBadgeAttribute()
    {
        $badges = [
            'admin' => 'danger',
            'hr' => 'warning',
            'pelamar' => 'primary'
        ];

        return $badges[$this->role] ?? 'secondary';
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        $initials = '';
        
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }
        
        return substr($initials, 0, 2);
    }

    // Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isHR()
    {
        return $this->role === 'hr';
    }

    public function isApplicant()
    {
        return $this->role === 'pelamar';
    }
}
