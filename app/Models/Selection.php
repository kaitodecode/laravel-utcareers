<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selection extends BaseModel
{

    // Relationships
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }
}
