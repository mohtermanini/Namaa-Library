<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $table= 'book_subscription';
    
    protected $fillable = ['subscription_id','book_id','borrow_date','return_date','identity_national_num',
                            'mortgage_amount'];
    public function book(){
        return $this->belongsTo("App\Models\Book");
    }
    public function subscription(){
        return $this->belongsTo("App\Models\Subscription");
    }
}
