<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;

    public function product_variation()
    {
        return $this->belongsTo(ProductVariation::class);
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id','id');
    }


}
