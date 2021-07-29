<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['start_date','end_date','fee','type_id','user_id'];
    protected $dates = ['deleted_at'];
    public function type(){
        return $this->belongsTo("App\Models\SubscriptionType");
    }

    public function remainingDuration(){
        $date = today();
        $start_date = Carbon::parse($this->start_date);
        if(today()->lt($start_date)){
            $date = $start_date;
        }
        return $date->diffInDays(Carbon::parse($this->end_date),false);
    }
    public function getDate($string){
        return Carbon::parse($string)->toDateString();
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function books(){
        return $this->belongsToMany("App\Models\Book")
                ->withPivot("borrow_date","return_date","identity_mortgage","mortgage_amount");
    }
}
