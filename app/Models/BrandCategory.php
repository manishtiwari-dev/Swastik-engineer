<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandCategory extends Model
{
    use HasFactory;

    protected $table = "category_brands";
    protected $guarded = ['id'];
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
   
}
