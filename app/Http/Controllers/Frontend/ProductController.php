<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Services\SmsServices;
use App\Models\AddOnProduct;
use App\Models\Product;
use App\Models\Brand;
use App\Models\ProductCategory;
use App\Models\ProductTag;
use App\Models\ProductVariation;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\ProductEnquiry;
use App\Notifications\ProductEnquiryNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;


class ProductController extends Controller
{
    # product listing
    public function index(Request $request, $slug)
    {
        $brands = Brand::where('slug', $slug)->first();
        if (!empty($brands))
            $brandId = $brands->id;


        if (empty($brands)) {
            flash(localize('This brand is not available'))->info();
            return redirect()->route('home');
        }

        $searchKey = null;
        $per_page = 12;
        $sort_by = $request->sort_by ? $request->sort_by : "new";
        $maxRange = Product::max('max_price');
        $min_value = 0;
        $max_value = formatPrice($maxRange, false, false, false, false);

        $products = Product::isPublished();

        # conditional - search by
        if ($request->search != null) {
            $products = $products->where('name', 'like', '%' . $request->search . '%');
            $searchKey = $request->search;
        }

        # pagination
        if ($request->per_page != null) {
            $per_page = $request->per_page;
        }

        # sort by
        if ($sort_by == 'new') {
            $products = $products->latest();
        } else {
            $products = $products->orderBy('total_sale_count', 'DESC');
        }

        # by price
        if ($request->min_price != null) {
            $min_value = $request->min_price;
        }
        if ($request->max_price != null) {
            $max_value = $request->max_price;
        }

        if ($request->min_price || $request->max_price) {
            $products = $products->where('min_price', '>=', $min_value)->where('min_price', '<=', $max_value);
        }

        # by category
        if ($request->category_id && $request->category_id != null) {
            $product_category_product_ids = ProductCategory::where('category_id', $request->category_id)->pluck('product_id');
            $products = $products->whereIn('id', $product_category_product_ids);
        }

        # by brand
        if ($brandId != null) {
            $brand_product_ids = Brand::where('id', $brandId)->pluck('id');
            $products = $products->whereIn('brand_id', $brand_product_ids);
        }


        # by tag
        if ($request->tag_id && $request->tag_id != null) {
            $product_tag_product_ids = ProductTag::where('tag_id', $request->tag_id)->pluck('product_id');
            $products = $products->whereIn('id', $product_tag_product_ids);
        }
        # conditional

        $products = $products->paginate(paginationNumber($per_page));

        $tags = Tag::all();
        return getView('pages.product_listing', [
            'products'      => $products,
            'brands'        =>$brands, 
            'searchKey'     => $searchKey,
            'per_page'      => $per_page,
            'sort_by'       => $sort_by,
            'max_range'     => formatPrice($maxRange, false, false, false, false),
            'min_value'     => $min_value,
            'max_value'     => $max_value,
            'tags'          => $tags,
        ]);
    }

    # product show
    public function show($slug)
    {   
        $product = Product::with('variations', 'categories')->where('slug', $slug)->first();
        // dd($product);
        if (empty($product)){
            flash(localize('This product is not available'))->info();
            return redirect()->route('home');
        }

        if (empty($product))
            return redirect()->route('home');

        if (auth()->check() && auth()->user()->user_type == "admin") {
            // do nothing
        } else {
            if ($product->is_published == 0) {
                flash(localize('This product is not available'))->info();
                return redirect()->route('home');
            }
        }

   
      
        $productCategories              = $product->categories()->pluck('category_id');
        $productIdsWithTheseCategories  = ProductCategory::whereIn('category_id', $productCategories)->where('product_id', '!=', $product->id)->pluck('product_id');

        $relatedProducts                = Product::whereIn('id', $productIdsWithTheseCategories)->get();

        # Attach AddOn Products
        $AddOnProducts = '';
        if (!empty($product->addon_products)) {
            $productIds = json_decode($product->addon_products);
            $AddOnProducts = AddOnProduct::whereIn('id', $productIds)->get();
        }

        $product_page_widgets = [];
        if (getSetting('product_page_widgets') != null) {
            $product_page_widgets = json_decode(getSetting('product_page_widgets'));
        }

        return getView('pages.product_detail', ['AddOnProducts' => $AddOnProducts, 'product' => $product, 'relatedProducts' => $relatedProducts, 'product_page_widgets' => $product_page_widgets]);
    }

    # product info
    public function showInfo(Request $request)
    {
        $product = Product::find($request->id);
        return getView('pages.partials.products.product-view-box', ['product' => $product]);
    }

    # product variation info
    public function getVariationInfo(Request $request)
    {
        $price = 0;
        $product = Product::where('id', $request->product_id)->first();

        if (!empty($product)) {

            $variationIds = $request->ids;
            if (!empty($variationIds)) {
                foreach ($variationIds as $variationKey) {
                    $productVariation = ProductVariation::where('variation_key', $variationKey)->where('product_id', $request->product_id)->first();
                    $price += $productVariation->price;
                }
            }

            return response()->json(['price' => $price, 'status' => 200]);
        }
    }


    public function enquiryProductStore(Request $request)
    {

        // dd( $request->all());

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
            ],
            [
                'name.required' => "Please enter a name.",
                'phone.required' => "Please enter a phone number.",
            ]
        );


        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validator->messages(),
            ]);
        } else {

            $enquiryPrd = new ProductEnquiry;
            $enquiryPrd->product_id = $request->product_id;
            $enquiryPrd->name    = $request->name;
            $enquiryPrd->email      = $request->email;
            $enquiryPrd->phone   = $request->phone;
            $enquiryPrd->message = $request->message;
            $enquiryPrd->user_agent  = $_SERVER['HTTP_USER_AGENT'] ?? '';
            $enquiryPrd->remote_addr  = $_SERVER['REMOTE_ADDR'] ?? '';

            $enquiryPrd->save();

            $product = Product::where('id', $request->product_id)->first();
            
            
            if (!empty($product)) {

                $product->total_sale_count += 1;
                $product->save();
            }
              // Send Mail Notification to admin
              $message="";
              $message.="New product enquiry received in".getSetting('system_title')."\n";
              $message.="Prduct Name : ".$product->name ?? 'n/a';
              $message.="Customer Name : ".$enquiryPrd->name ?? 'n/a';
              $message.="Customer Email : ".$enquiryPrd->email ?? 'n/a';
              $message.="Customer Phone : ".$enquiryPrd->phone ?? 'n/a';
              $message.="Thank You";
              SmsServices::SendSMS(getSetting('order_contact_number'),$message); #To Admin
               // SmsServices::SendSMS($order->phone_no,$message); #To Customer

            Notification::route('mail','sawos76058@fulwark.com')->notify(new ProductEnquiryNotification($enquiryPrd));

            return response()->json(['enquiryPrd' => $enquiryPrd, 'status' => 200]);
        }
    }


    function downloadAttachment($id)
    {

        $product = Product::find($id);

        if (!empty($product)) {

            $path = asset('storage/' . $product->attachment);
            return response()->download($path, $product->name . '.pdf');
        } else {
            return back();
        }
    }
}
