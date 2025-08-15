<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends BaseModel
{
    protected $fillable = [
        'user_id',
        'job_post_category_id',
        'status',
        'cv',
        'national_identity_card'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobPostCategory()
    {
        return $this->belongsTo(JobPostCategory::class, 'job_post_category_id');
    }

    public function selections()
    {
        return $this->hasMany(Selection::class);
    }



    // Scopes
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByJobPostCategory($query, $jobPostCategoryId)
    {
        return $query->where('job_post_category_id', $jobPostCategoryId);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInSelection($query)
    {
        return $query->where('status', 'selection');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'warning',
            'selection' => 'info',
            'accepted' => 'success',
            'rejected' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Menunggu Review',
            'selection' => 'Dalam Seleksi',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak'
        ];

        return $labels[$this->status] ?? 'Unknown';
    }
}
