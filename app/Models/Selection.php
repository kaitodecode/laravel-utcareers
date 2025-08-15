<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends BaseModel
{
    protected $fillable = [
        'applicant_id',
        'job_post_category_id',
        'stage',
        'status',
        'attachment'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function jobPostCategory()
    {
        return $this->belongsTo(JobPostCategory::class, 'job_post_category_id');
    }

    // Scopes
    public function scopeByStage($query, $stage)
    {
        return $query->where('stage', $stage);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePortfolioStage($query)
    {
        return $query->where('stage', 'portfolio');
    }

    public function scopeInterviewStage($query)
    {
        return $query->where('stage', 'interview');
    }

    public function scopeMedicalCheckupStage($query)
    {
        return $query->where('stage', 'medical_checkup');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'accepted' => 'bg-success',
            'rejected' => 'bg-danger',
            'pending' => 'bg-warning'
        ];

        return $badges[$this->status] ?? 'bg-secondary';
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
            'pending' => 'Menunggu Review'
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    public function getStageLabelAttribute()
    {
        $labels = [
            'portfolio' => 'Review Portfolio',
            'interview' => 'Wawancara',
            'medical_checkup' => 'Medical Check-up'
        ];

        return $labels[$this->stage] ?? 'Unknown';
    }
}
