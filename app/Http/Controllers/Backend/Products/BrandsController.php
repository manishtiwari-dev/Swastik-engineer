<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\BrandLocalization;
use App\Models\Category;
use App\Models\CategoryBrand;
use App\Models\CategoryBrands;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:brands'])->only('index');
        $this->middleware(['permission:add_brands'])->only(['store']);
        $this->middleware(['permission:edit_brands'])->only(['edit', 'update']);
        $this->middleware(['permission:publish_brands'])->only(['updateStatus']);
        $this->middleware(['permission:delete_brands'])->only(['delete']);
    }

    # brand list
    public function index(Request $request)
    {
        $searchKey = null;
        $is_published = null;

        $brands = Brand::oldest();
        if ($request->search != null) {
            $brands = $brands->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->is_published != null) {
            $brands = $brands->where('is_active', $request->is_published);
            $is_published    = $request->is_published;
        }

        $categories = Category::where('parent_id', 0)
        ->orderBy('sorting_order_level', 'desc')
        ->with('childrenCategories')
        ->get();

        $brands = $brands->paginate(paginationNumber());
        return view('backend.pages.products.brands.index', compact('brands','categories', 'searchKey', 'is_published'));
    }

    # brand store
    public function store(Request $request)
    {

        $brand = new Brand;
        $brand->name = $request->name;
        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        $brand->brand_image = $request->image;
        $brand->meta_image = $request->meta_image;

        if ($request->sorting_order_level != null) {
            $brand->sorting_order_level = $request->sorting_order_level;
        }


        $brand->slug=getUniqueValue('Brand', 'slug', [2, 2],$request->name,false);
        $brand->save();

        $brandLocalization = BrandLocalization::firstOrNew(['lang_key' => env('DEFAULT_LANGUAGE'), 'brand_id' => $brand->id]);
        $brandLocalization->name = $brand->name;
        $brandLocalization->meta_title = $brand->meta_title;
        $brandLocalization->meta_description = $brand->meta_description;
        $brandLocalization->brand_image = $request->image;
        $brandLocalization->meta_image = $request->meta_image;

        $brandLocalization->save();

        $categories=$request->categories_id;

        if(!empty($categories)) {
            foreach($categories as $brandCategory) {

                BrandCategory::create([
                    'category_id'=>$brandCategory,
                    'brand_id'=>$brand->id,
                ]);

            }
        }

        $brand->save();
        flash(localize('Brand has been inserted successfully'))->success();
        return redirect()->route('admin.brands.index');
    }

    # edit brand
    public function edit(Request $request, $id)
    {
        $lang_key = $request->lang_key;
        $language = Language::isActive()->where('code', $lang_key)->first();
        if (!$language) {
            flash(localize('Language you are trying to translate is not available or not active'))->error();
            return redirect()->route('admin.brands.index');
        }
        $brand = Brand::findOrFail($id);

        $categories = Category::where('parent_id', 0)
        ->orderBy('sorting_order_level', 'desc')
        ->with('childrenCategories')
        ->get();

        $brandCategories=BrandCategory::where('brand_id',$brand->id)->pluck('category_id');

        return view('backend.pages.products.brands.edit', compact('brand', 'lang_key','brandCategories','categories'));
    }

    # update brand
    public function update(Request $request)
    {
        // dd($request->all());
        $brand = Brand::findOrFail($request->id);
        if ($request->lang_key == env("DEFAULT_LANGUAGE")) {
            $brand->name = $request->name;

            // if ($request->slug != null) {
            //     $brand->slug=getUniqueValue('Brand', 'slug', [2, 2],$request->slug,false);
            // }

            // $brand->slug = (!is_null($request->slug)) ? Str::slug($request->slug, '-') : Str::slug($request->name, '-') . '-' . strtolower(Str::random(5));
            $brand->meta_title = $request->meta_title;
            $brand->meta_description = $request->meta_description;
        }

        $brandLocalization = BrandLocalization::firstOrNew(['lang_key' => $request->lang_key, 'brand_id' => $brand->id]);
        $brandLocalization->name = $request->name;
        $brandLocalization->meta_title = $request->meta_title;
        $brandLocalization->meta_description = $request->meta_description;
        $brandLocalization->brand_image = $request->image;
        $brandLocalization->meta_image = $request->meta_image;

        $categories=$request->categories_id;

        if(!empty($categories)) {
            BrandCategory::where('brand_id',$brand->id)->delete();

            foreach($categories as $brandCategory) {

                BrandCategory::create([
                    'category_id'=>$brandCategory,
                    'brand_id'=>$brand->id,
                ]);
            }
        }

        if ($request->sorting_order_level != null) {
            $brand->sorting_order_level = $request->sorting_order_level;
        }

        $brand->save();
        $brandLocalization->save();

        flash(localize('Brand has been updated successfully'))->success();
        return back();
    }

    # update status
    public function updateStatus(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $brand->is_active = $request->is_active;
        if ($brand->save()) {
            return 1;
        }
        return 0;
    }

    # delete brand
    public function delete($id)
    {
        $brand = Brand::findOrFail($id);

        try {
            Product::where('brand_id', $id)->update([
                'brand_id' => NULL
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }

        $brand->delete();
        flash(localize('Brand has been deleted successfully'))->success();
        return back();
    }
}
