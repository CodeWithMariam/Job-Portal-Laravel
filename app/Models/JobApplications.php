<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplications extends Model
{
     // Specify the correct table name
     protected $table = 'jobs_applications';

     public function job(){
         return $this->belongsTo(Job::class);
     }

     public function user(){
        return $this->belongsTo(User::class);
    }
    public function employer(){
        return $this->belongsTo(User::class,'employer_id');
    }
}
