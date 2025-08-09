<?php

namespace App\Models;

class Company extends BaseModel
{
    // Relationships
    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }
}
