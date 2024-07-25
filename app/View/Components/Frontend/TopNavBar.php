<?php

namespace App\View\Components\Frontend;

use Illuminate\View\Component;
use Illuminate\View\View;
use Auth;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\BrandCategory;





class TopNavBar extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {

        //brand list
        $brand_category_data = BrandCategory::select('category_id')->distinct()->get();
        if (!empty($brand_category_data)) {
            $brand_category_data = $brand_category_data->map(function ($data) {
                $cat = Category::with('brands')->where('id', $data->category_id)->get();
                $data->cat = $cat;
                return $data;
            });
        }
        //end brand list

        //category list
        $category_data = Category::where('parent_id', 0)->orderBy('sorting_order_level','ASC')->get();
        $category_data = $category_data->map(function ($data) {
            // getting  sub category
            $sub_category = Category::where('parent_id', $data->id)->orderBy('sorting_order_level','ASC')->get();
            if (!empty($sub_category)) {
                if (sizeof($sub_category) > 0) {
                    $sub_category = $sub_category->map(function ($sub) {
                        // getting sub sub category
                        $sub_sub_category = Category::where('parent_id', $sub->id)->get();
                        $sub->sub_sub_category = $sub_sub_category;
                        return $sub;
                    });
                }
            }

            $data->sub_category = $sub_category;

            return $data;
        });
        //end category list


        return getView('inc.header', ['category_data' => $category_data, 'brand_category_data' => $brand_category_data]);
    }
}
