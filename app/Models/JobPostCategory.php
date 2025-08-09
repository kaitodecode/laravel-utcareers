<?php

namespace App\Models;


class JobPostCategory extends BaseModel
{
    protected $fillable = [
        'job_category_id',
        'job_post_id',
        'type',
        'required_count',
        'description',
        'requirements',
        'benefits'
    ];

    protected $casts = [
        'required_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relationships
    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }

    // Scopes
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeFullTime($query)
    {
        return $query->where('type', 'full_time');
    }

    public function scopePartTime($query)
    {
        return $query->where('type', 'part_time');
    }

    public function scopeContract($query)
    {
        return $query->where('type', 'contract');
    }

    public function scopeRemote($query)
    {
        return $query->where('type', 'remote');
    }

    // Accessors
    public function getTypeLabelAttribute()
    {
        $labels = [
            'full_time' => 'Full Time',
            'part_time' => 'Part Time',
            'contract' => 'Contract',
            'remote' => 'Remote'
        ];

        return $labels[$this->type] ?? 'Unknown';
    }
}
