<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['date','course_id'];
    public function course(){
        return $this->belongsTo("App\Models\Course");
    }
    public function users(){
        return $this->belongsToMany("App\Models\User")->withPivot("paid");
    }
}
