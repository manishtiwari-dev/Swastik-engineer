<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Tag;
use App\Models\Tax;
use App\Models\ProductLocalization;

class AddOnProduct extends Model
{
    use HasFactory;

    public function scopeIsPublished($query)
    {
        return $query->where('is_published', 1);
    }
    
    protected $table = 'addon_products';
    
    protected $guarded = ['id'];

    protected $with = ['product_localizations'];
    
    public function product_localizations()
    {
        return $this->hasMany(ProductLocalization::class,'product_id','id');
    }

    public function collectLocalization($entity = '', $lang_key = '')
    {  
        $lang_key = $lang_key ==  '' ? app()->getLocale() : $lang_key;
        $product_localizations = $this->product_localizations->where('lang_key', $lang_key)->where('source',2)->first();
        return $product_localizations != null && $product_localizations->$entity ? $product_localizations->$entity : $this->$entity;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function taxes()
    {
        return $this->hasMany(ProductTax::class);
    }

    public function product_taxes()
    {
        return $this->belongsToMany(Tax::class, 'product_taxes', 'product_id', 'tax_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

}
