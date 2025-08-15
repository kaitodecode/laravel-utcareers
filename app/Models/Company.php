<?php

namespace App\Models;

class Company extends BaseModel
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'logo',
        'location',
        'description'
    ];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }


}
