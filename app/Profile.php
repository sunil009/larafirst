<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Country;
use App\State;
use App\City;

class Profile extends Model {

    use SoftDeletes;

    protected $guarded = [];	
    protected $dates = ['deleted_at'];

    public function user() {

    	return $this->belongsTo(User::class);
    }

    public function getRouteKeyName() {

    	return "slug";
    }

    public function country() {

    	return $this->belongsTo(Country::class);
    }

    public function state() {

    	return $this->belongsTo(State::class);
    }

    public function city() {

    	return $this->belongsTo(City::class);
    }
}
