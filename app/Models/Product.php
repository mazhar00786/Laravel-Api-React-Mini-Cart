<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'meta_title',
        'meta_keyword',
        'meat_description',
        'slug',
        'name',
        'description',
        'brand',
        'selling_price',
        'original_price',
        'quantity',
        'image',
        'featured',
        'popular',
        'status',         
    ];

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    //To be used in jQuery, ajax or in react 
    protected $with = ['category']; //use this in react jQuery or ajax as relation ship

    //this relation function to be used in laravel
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
