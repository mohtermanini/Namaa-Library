<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Models\User;
use Config;

class ActivitiesController extends Controller
{
    public function index($title){
        $type_id = SubscriptionType::where('name',$title)->first()->id;
        if(request()->user_name_search){
            if(request()->user_id != -1){
            $subscriptions = Subscription::with("user")->where('type_id',$type_id)
                        ->where("user_id",request()->user_id)
                        ->orderBy("start_date","desc")
                        ->paginate(Config::get('pagination_num'));
            }else{
                $subscriptions = Subscription::with("user")->where('type_id',$type_id)
                        ->whereHas("user",function($query){
                            $query->where('name','like','%'.request()->user_name_search.'%');
                        })->orderBy("start_date","desc")
                        ->paginate(Config::get('pagination_num'));
            }
        }else{
        $subscriptions = Subscription::with("user")->where('type_id',$type_id)
            ->orderBy("start_date","desc")
            ->paginate(Config::get('pagination_num'));
        }
        return view('activities')->with("title",$title)
                                        ->with("subscriptions",$subscriptions)
                                        ->with("search_url",route('activities.search'));
    }
    public function users_search(Request $request){
        $type_id =SubscriptionType::where('name',$request->title)->first()->id;
        return User::whereHas('subscriptions',function($query) use ($type_id){
            $query->where("type_id",$type_id);
        })->where('name','like',"%{$request->name}%")
        ->limit(Config::get("max_search_items"))
        ->get(['name as label','id as value']);
    }
}
