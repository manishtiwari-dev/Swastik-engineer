<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductVariationInfoResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\ProductVariation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class CategoryController extends Controller
{
    # product listing

    public function show(Request $request, $slug)
    {
        $per_page = 12;

        $category = Category::where('slug', $slug)->first();
        if (empty($category)) {
            flash(localize('This product is not available'))->info();
            return redirect()->route('home');
        } else {

            $products = Product::isPublished();

             // all products show parent child
            if ($category->parent_id == 0) {
                $parent_data = Category::where('parent_id', $category->id)->pluck('id');
                if (!empty($parent_data)) {
                    $products = $products->whereHas('categories', function (Builder $query) use ($parent_data) {
                        $query->whereIn('product_categories.category_id', $parent_data);
                    });
                }
            }
            // child category wise products
            if ($category->parent_id != 0) {
                $catId =  $category->id;
                $products = $products->whereHas('categories', function (Builder $query) use ($catId) {
                    $query->where('product_categories.category_id', $catId);
                });
            }

        


            // $product_category_product_ids = ProductCategory::where('category_id', $category->id)->pluck('product_id');
            // $products = $products->whereIn('id', $product_category_product_ids);

            $products = $products->paginate(paginationNumber($per_page));

            return getView('pages.product_listing', [
                'products'      => $products,
                'category'      => $category,
            ]);
        }
    }
}
