<?php

namespace App\Http\Controllers\Backend\Products;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Tax;
use App\Models\Category;
use App\Models\AddOnProduct;
use App\Models\ProductLocalization;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddOnProductsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:products'])->only('index');
        $this->middleware(['permission:add_products'])->only(['create', 'store']);
        $this->middleware(['permission:edit_products'])->only(['edit', 'update']);
        $this->middleware(['permission:publish_products'])->only(['updatePublishedStatus']);
    }

    # product list
    public function index(Request $request)
    {   
        $searchKey = null;
        $brand_id = null;
        $is_published = null;

        $products = AddOnProduct::latest();

        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        if ($request->is_published != null) {
            $products = $products->where('is_published', $request->is_published);
            $is_published    = $request->is_published;
        }

        $products = $products->paginate(paginationNumber());
        return view('backend.pages.products.AddonProducts.index', compact('products','searchKey','is_published'));
    }

    # return view of create form
    public function create()
    {
        $categories = Category::where('parent_id', 0)
            ->orderBy('sorting_order_level', 'desc')
            ->with('childrenCategories')
            ->get();

        $taxes = Tax::isActive()->get();
        $tags = Tag::all();
        return view('backend.pages.products.AddonProducts.create', compact('categories', 'taxes', 'tags'));
    }




    # add new data
    public function store(Request $request)
    {   
        $product                    = new AddOnProduct;
        $product->shop_id           = auth()->user()->shop_id; #user id
        $product->name              = $request->name;
        $product->slug              = Str::slug($request->name, '-') . '-' . strtolower(Str::random(5));

        $product->thumbnail_image   = $request->image;
        $product->gallery_images    = $request->gallery_images;

        $product->description       = $request->description;
        $product->short_description = $request->short_description;

        $product->price             =  $request->price;
        
        $product->is_published      = $request->is_published;
     
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_img = $request->meta_image;

        $product->save();

        # Product Localization
        $ProductLocalization = ProductLocalization::firstOrNew(['lang_key' => env('DEFAULT_LANGUAGE') ?? 'en', 'product_id' => $product->id]);
        $ProductLocalization->name = $request->name;
        $ProductLocalization->description = $request->description;
        $ProductLocalization->source = 2;
        $ProductLocalization->save();

        # tags
        $product->tags()->sync($request->tag_ids);

        # category
        $product->categories()->sync($request->category_ids);

        # taxes
        $tax_data = array();
        $tax_ids = array();
        if ($request->has('taxes')) {
            foreach ($request->taxes as $key => $tax) {
                array_push($tax_data, [
                    'tax_value' => $tax,
                    'tax_type' => $request->tax_types[$key]
                ]);
            }
            $tax_ids = $request->tax_ids;
        }
        $taxes = array_combine($tax_ids, $tax_data);
        $product->product_taxes()->sync($taxes);

        flash(localize('Product has been inserted successfully'))->success();
        return redirect()->route('admin.addon-products.index');
    }

    # return view of edit form
    public function edit(Request $request, $id)
    {   
    
        $lang_key = $request->lang_key ?? '';
        $language = Language::where('is_active', 1)->where('code', $lang_key)->first();
        if (!$language) {
            flash(localize('Language you are trying to translate is not available or not active'))->error();
            return redirect()->route('admin.products.index');
        }
        $product = AddOnProduct::findOrFail($id);
        $categories = Category::where('parent_id', 0)
            ->orderBy('sorting_order_level', 'desc')
            ->with('childrenCategories')
            ->get();
        $taxes = Tax::isActive()->get();
        $tags = Tag::all();
        return view('backend.pages.products.AddonProducts.edit', compact('product', 'categories','taxes', 'lang_key', 'tags'));
    }

    # update product
    public function update(Request $request)
    {   
        $product = AddOnProduct::where('id', $request->id)->first();

        if ($product->shop_id != auth()->user()->shop_id) {
            abort(403);
        }

        if ($request->lang_key == env("DEFAULT_LANGUAGE")) {
            $product->name              = $request->name;
            $product->slug              = (!is_null($request->slug)) ? Str::slug($request->slug, '-') : Str::slug($request->name, '-') . '-' . strtolower(Str::random(5));
            $product->description       = $request->description;
            $product->short_description = $request->short_description;

            $product->thumbnail_image   = $request->image;
            $product->gallery_images    = $request->gallery_images;

            $product->price             =$request->price;

            $product->is_published      = $request->is_published;

            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->meta_img = $request->meta_image;

            $product->save();

            # tags
            $product->tags()->sync($request->tag_ids);

            # category
            $product->categories()->sync($request->category_ids);

            # taxes
            $tax_data = array();
            $tax_ids = array();
            if ($request->has('taxes')) {
                foreach ($request->taxes as $key => $tax) {
                    array_push($tax_data, [
                        'tax_value' => $tax,
                        'tax_type' => $request->tax_types[$key]
                    ]);
                }
                $tax_ids = $request->tax_ids;
            }
            $taxes = array_combine($tax_ids, $tax_data);
            $product->product_taxes()->sync($taxes);

        }
        # Product Localization
        $ProductLocalization = ProductLocalization::firstOrNew(['lang_key' => $request->lang_key ?? 'en', 'product_id' => $product->id]);
        $ProductLocalization->name = $request->name;
        $ProductLocalization->description = $request->description;
        $ProductLocalization->short_description = $request->short_description;
        $ProductLocalization->source = 2;
        $ProductLocalization->save();

        flash(localize('Product has been updated successfully'))->success();
        return back();
    }

   
    # update published
    public function updatePublishedStatus(Request $request)
    {
        $product = AddOnProduct::findOrFail($request->id);
        $product->is_published = $request->status;
        if ($product->save()) {
            return 1;
        }
        return 0;
    }

    # delete product
    public function delete($id)
    {
        #
    }
}
