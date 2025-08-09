<?php

namespace App\Models;

class Company extends BaseModel
{

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function jobPosts()
    {
        return $this->hasMany(JobPost::class);
    }

    public function parentCompany()
    {
        return $this->belongsTo(Company::class, 'parent_company_id');
    }

    public function subsidiaries()
    {
        return $this->hasMany(Company::class, 'parent_company_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByBusinessSector($query, $sector)
    {
        return $query->where('business_sector', $sector);
    }

    public function scopeByCompanyType($query, $type)
    {
        return $query->where('company_type', $type);
    }
}
