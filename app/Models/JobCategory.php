<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends BaseModel
{
    // Relationships
    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'job_categories_job_posts', 'job_category_id', 'job_post_id');
    }
}
