<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =['title','author','count','available_count','category_id'];
    protected $dates = ['deleted_at'];
    public function category(){
        return $this->belongsTo("App\Models\Category");
    }
    public function subscriptions(){
        return $this->belongsToMany("App\Models\Subscription")
                    ->withPivot("borrow_date","return_date","identity_mortgage","mortgage_amount");
    }
}
