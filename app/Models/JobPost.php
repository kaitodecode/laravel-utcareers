<?php

namespace App\Models;

class JobPost extends BaseModel
{

    protected $fillable = [
        'company_id',
        'title',
        'thumbnail',
        'status'
    ];

    protected $casts = [
        //
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobCategories()
    {
        return $this->belongsToMany(JobCategory::class, 'job_post_categories', 'job_post_id', 'job_category_id')
                    ->withPivot('type', 'required_count', 'description', 'requirements', 'benefits')
                    ->withTimestamps();
    }

    public function jobPostCategories()
    {
        return $this->hasMany(JobPostCategory::class);
    }

    public function applicants()
    {
        return $this->hasManyThrough(Applicant::class, JobPostCategory::class, 'job_post_id', 'job_post_category_id');
    }

    public function selections()
    {
        return $this->hasManyThrough(Selection::class, JobPostCategory::class, 'job_post_id', 'job_post_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
