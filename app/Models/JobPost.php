<?php

namespace App\Models;

class JobPost extends BaseModel
{
    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobCategories()
    {
        return $this->belongsToMany(JobCategory::class, 'job_categories_job_posts', 'job_post_id', 'job_category_id');
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'job_id');
    }

    public function selections()
    {
        return $this->hasMany(Selection::class, 'job_id');
    }
}
