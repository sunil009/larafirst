<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Product;

class Category extends Model {
    
    protected $guarded = [];

    use SoftDeletes;	

    protected $data = ['deleted_at'];

    public function products() {

    	return $this->belongsToMany(Product::class);
    }

    public function childrens() {
    	return $this->belongsToMany(Category::class, 'category_parent', 'category_id', 'parent_id');
    }
}
