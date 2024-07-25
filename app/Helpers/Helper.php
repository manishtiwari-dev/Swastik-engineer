<?php

use App\Http\Middleware\ApiCurrencyMiddleWare;
use App\Models\AddOnProduct;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Localization;
use App\Models\MediaManager;
use App\Models\Product;
use App\Models\SystemSetting;
use App\Models\Variation;
use App\Models\VariationValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

if (!function_exists('getTheme')) {
    # get system theme
    function getTheme()
    {
        if (session('theme') != null && session('theme') != '') {
            return session('theme');
        }
        return Config::get('app.theme');
    }
}

if (!function_exists('getView')) {
    # get view of theme
    function getView($path, $data = [])
    {
        return view('frontend.' . getTheme() . '.' . $path, $data);
    }
}

if (!function_exists('getViewRender')) {
    # get view of theme with render
    function getViewRender($path, $data = [])
    {
        return view('frontend.' . getTheme() . '.' . $path, $data)->render();
    }
}

if (!function_exists('cacheClear')) {
    # clear server cache
    function cacheClear()
    {
        try {
            Artisan::call('cache:forget spatie.permission.cache');
        } catch (\Throwable $th) {
            //throw $th;
        }

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('config:clear');
    }
}

if (!function_exists('clearOrderSession')) {
    # clear session cache
    function clearOrderSession()
    {
        session()->forget('payment_method');
        session()->forget('payment_type');
        session()->forget('order_code');
    }
}

if (!function_exists('csrfToken')) {
    #  Get the CSRF token value.
    function csrfToken()
    {
        $session = app('session');

        if (isset($session)) {
            return $session->token();
        }
        throw new RuntimeException('Session store not set.');
    }
}

if (!function_exists('paginationNumber')) {
    # return number of data per page
    function paginationNumber($value = null)
    {
        return $value != null ? $value : env('DEFAULT_PAGINATION');
    }
}

if (!function_exists('areActiveRoutes')) {
    # return active class
    function areActiveRoutes(array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }
        return '';
    }
}

if (!function_exists('validatePhone')) {
    # validatePhone
    function validatePhone($phone)
    {
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('-', '', $phone);
        return $phone;
    }
}


if (!function_exists('staticAsset')) {
    # return path for static assets
    function staticAsset($path, $secure = null)
    {
        if (str_contains(url('/'), '.test') || str_contains(url('/'), 'http://127.0.0.1:')) {
            return app('url')->asset('' . $path, $secure) . '?v=' . env('APP_VERSION');
        }
        return app('url')->asset('public/' . $path, $secure) . '?v=' . env('APP_VERSION');
    }
}

if (!function_exists('staticAssetApi')) {
    # return path for static assets
    function staticAssetApi($path, $secure = null)
    {
        if (str_contains(url('/'), '.test') || str_contains(url('/'), 'http://127.0.0.1:')) {
            return app('url')->asset('' . $path, $secure);
        }
        return app('url')->asset('public/' . $path, $secure);
    }
}

if (!function_exists('uploadedAsset')) {
    #  Generate an asset path for the uploaded files.
    function uploadedAsset($fileId)
    {   
        $mediaFile = MediaManager::find($fileId);
        if (!is_null($mediaFile)) {
            return asset('storage/'.$mediaFile->media_file);
        }
        return '';
    }
}

if (!function_exists('uploadedAssetes')) {
    #  Generate an asset path for the uploaded files.
    function uploadedAssetes($ids)
    {
        $ids = explode(",", $ids);

        $assets = [];
        $mediaFiles = MediaManager::whereIn('id', $ids)->get();

        if ($mediaFiles) {

            foreach ($mediaFiles as $file) {
                if (str_contains(url('/'), '.test') || str_contains(url('/'), 'http://127.0.0.1:')) {
                    $assets[] = app('url')->asset('' . $file->media_file);
                }
                $assets[] = app('url')->asset('public/' . $file->media_file);
            }
        }
        return $assets;
    }
}

if (!function_exists('productStock')) {
    #  get product stock
    function productStock($product)
    {

        $isVariantProduct = 0;
        $stock = 0;
        if ($product->variations()->count() > 1) {
            $isVariantProduct = 1;
        } else {
            $stock = $product->variations[0]->product_variation_stock ? $product->variations[0]->product_variation_stock->stock_qty : 0;
        }
        return $stock;
    }
}



if (!function_exists('localize')) {
    # add / return localization
    function localize($key, $lang = null)
    {
        if ($lang == null) {
            $lang = App::getLocale();
        }

        $t_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($key)));

        $localization_english = Cache::rememberForever('localizations-en', function () {
            return Localization::where('lang_key', 'en')->pluck('t_value', 't_key');
        });

        if (!isset($localization_english[$t_key])) {
            # add new localization
            newLocalization('en', $t_key, $key);
        }

        # return user session lang
        $localization_user = Cache::rememberForever("localizations-{$lang}", function () use ($lang) {
            return Localization::where('lang_key', $lang)->pluck('t_value', 't_key')->toArray();
        });

        if (isset($localization_user[$t_key])) {
            return trim($localization_user[$t_key]);
        }

        return isset($localization_english[$t_key]) ? trim($localization_english[$t_key]) : $key;
    }
}

if (!function_exists('newLocalization')) {
    # new localization
    function newLocalization($lang, $t_key, $key)
    {
        $localization = new Localization;
        $localization->lang_key = $lang;
        $localization->t_key = $t_key;
        $localization->t_value = str_replace(array("\r", "\n", "\r\n"), "", $key);
        $localization->save();

        # clear cache
        Cache::forget('localizations-' . $lang);

        return trim($key);
    }
}

if (!function_exists('writeToEnvFile')) {
    # write To Env File
    function
    writeToEnvFile($type, $val)
    {
        
        $path = base_path('.env');
        if (file_exists($path)) {
            $val = '"' . trim($val) . '"';
            if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
                file_put_contents($path, str_replace(
                    $type . '="' . env($type) . '"',
                    $type . '=' . $val,
                    file_get_contents($path)
                ));
            } else {
                file_put_contents($path, file_get_contents($path) . "\r\n" . $type . '=' . $val);
            }
        }
        
    }
}

if (!function_exists('getFileType')) {
    #  Get file Type
    function getFileType($type)
    {
        $fileTypeArray = [
            // audio
            "mp3"       =>  "audio",
            "wma"       =>  "audio",
            "aac"       =>  "audio",
            "wav"       =>  "audio",

            // video
            "mp4"       =>  "video",
            "mpg"       =>  "video",
            "mpeg"      =>  "video",
            "webm"      =>  "video",
            "ogg"       =>  "video",
            "avi"       =>  "video",
            "mov"       =>  "video",
            "flv"       =>  "video",
            "swf"       =>  "video",
            "mkv"       =>  "video",
            "wmv"       =>  "video",

            // image
            "png"       =>  "image",
            "svg"       =>  "image",
            "gif"       =>  "image",
            "jpg"       =>  "image",
            "jpeg"      =>  "image",
            "webp"      =>  "image",

            // document
            "doc"       =>  "document",
            "txt"       =>  "document",
            "docx"      =>  "document",
            "pdf"       =>  "document",
            "csv"       =>  "document",
            "xml"       =>  "document",
            "ods"       =>  "document",
            "xlr"       =>  "document",
            "xls"       =>  "document",
            "xlsx"      =>  "document",

            // archive
            "zip"       =>  "archive",
            "rar"       =>  "archive",
            "7z"        =>  "archive"
        ];
        return isset($fileTypeArray[$type]) ? $fileTypeArray[$type] : null;
    }
}

if (!function_exists('fileDelete')) {
    # file delete
    function fileDelete($file)
    {
        if (File::exists('public/' . $file)) {
            File::delete('public/' . $file);
        }
    }
}

if (!function_exists('getSetting')) {
    # return system settings value
    function getSetting($key, $default = null)
    {
        try {
            $settings = Cache::remember('settings', 86400, function () {
                return SystemSetting::all();
            });

            $setting = $settings->where('entity', $key)->first();

            return $setting == null ? $default : $setting->value;
        } catch (\Throwable $th) {
            return $default;
        }
    }
}



if (!function_exists('formatPrice')) {

    //formats price - truncate price to 1M, 2K if activated by admin
    function formatPrice($price, $truncate = false, $forceTruncate = false, $addSymbol = true, $numberFormat = true)
    {
        if ($numberFormat) {
            // truncate price
            if ($truncate) {
                if (getSetting('truncate_price') == 1 || $forceTruncate == true) {
                    if ($price < 1000000) {
                        // less than a million
                        $price = number_format($price, getSetting('no_of_decimals'));
                    } else if ($price < 1000000000) {
                        // less than a billion
                        $price = number_format($price / 1000000, getSetting('no_of_decimals')) . 'M';
                    } else {
                        // at least a billion
                        $price = number_format($price / 1000000000, getSetting('no_of_decimals')) . 'B';
                    }
                }
            } else {
                // decimals
                if (getSetting('no_of_decimals') > 0) {
                    $price = number_format($price, getSetting('no_of_decimals'));
                } else {
                    $price = number_format($price, getSetting('no_of_decimals'), '.', ',');
                }
            }
        }

        if ($addSymbol) {
            // currency symbol
            if (request()->hasHeader('Currency-Code')) {
                $symbol             =   ApiCurrencyMiddleWare::currencyData()->symbol;
                $symbolAlignment    =    ApiCurrencyMiddleWare::currencyData()->alignment;
            } else {
                $symbol             = Session::has('currency_symbol')           ? Session::get('currency_symbol')           : env('DEFAULT_CURRENCY_SYMBOL');
                $symbolAlignment    = Session::has('currency_symbol_alignment') ? Session::get('currency_symbol_alignment') : env('DEFAULT_CURRENCY_SYMBOL_ALIGNMENT');
            }
            if ($symbolAlignment == 0) {
                return $symbol . $price;
            } else if ($symbolAlignment == 1) {
                return $price . $symbol;
            } else if ($symbolAlignment == 2) {
                # space
                return $symbol . ' ' . $price;
            } else {
                # space
                return $price . ' ' .  $symbol;
            }
        }
        return $price;
    }
}

if (!function_exists('apiProductPrice')) {
    //formats price - truncate price to 1M, 2K if activated by admin
    function apiProductPrice($product)
    {
        $price = "00";
        if (productBasePrice($product) == discountedProductBasePrice($product)) {
            if (productBasePrice($product) == productMaxPrice($product)) {
                $price = formatPrice(productBasePrice($product));
            } else {
                $price = formatPrice(productBasePrice($product)) .
                    "-"
                    . formatPrice(productMaxPrice($product));
            }
        } else {
            if (discountedProductBasePrice($product) == discountedProductMaxPrice($product))
                $price = formatPrice(discountedProductBasePrice($product));
            else
                $price = formatPrice(discountedProductBasePrice($product)) .
                    "-"
                    . formatPrice(discountedProductMaxPrice($product));
        }
        return $price;
    }
}




if (!function_exists('productBasePrice')) {
    // min/base price of a product
    function productBasePrice($product, $formatted = false)
    {
        $price = $product->min_price;
        $tax = 0;

        foreach ($product->taxes as $productTax) {
            if ($productTax->tax_type == 'percent') {
                $tax += ($price * $productTax->tax_value) / 100;
            } elseif ($productTax->tax_type == 'flat') {
                $tax += $productTax->tax_value;
            }
        }

        $price += $tax;
        return $formatted ? formatPrice($price) : $price;
    }
}

if (!function_exists('discountedProductBasePrice')) {
    // min/base price of a product with discount
    function discountedProductBasePrice($product, $formatted = false)
    {
        $price = $product->min_price;

        $discount_applicable = false;

        if ($product->discount_start_date == null || $product->discount_end_date == null) {
            $discount_applicable = false;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount_value) / 100;
            } elseif ($product->discount_type == 'flat') {
                $price -= $product->discount_value;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $price += ($price * $product_tax->tax_value) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $price += $product_tax->tax_value;
            }
        }

        return $formatted ? formatPrice($price) : $price;
    }
}

if (!function_exists('productMaxPrice')) {
    // max price of a product
    function productMaxPrice($product, $formatted = false)
    {
        $price = $product->max_price;
        $tax = 0;

        foreach ($product->taxes as $productTax) {
            if ($productTax->tax_type == 'percent') {
                $tax += ($price * $productTax->tax_value) / 100;
            } elseif ($productTax->tax_type == 'flat') {
                $tax += $productTax->tax_value;
            }
        }

        $price += $tax;
        return $formatted ? formatPrice($price) : $price;
    }
}

if (!function_exists('discountedProductMaxPrice')) {
    // max price of a product with discount
    function discountedProductMaxPrice($product, $formatted = false)
    {
        $price = $product->max_price;

        $discount_applicable = false;

        if ($product->discount_start_date == null || $product->discount_end_date == null) {
            $discount_applicable = false;
        } elseif (
            strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
            strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        ) {
            $discount_applicable = true;
        }

        if ($discount_applicable) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount_value) / 100;
            } elseif ($product->discount_type == 'flat') {
                $price -= $product->discount_value;
            }
        }

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $price += ($price * $product_tax->tax_value) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $price += $product_tax->tax_value;
            }
        }

        return $formatted ? formatPrice($price) : $price;
    }
}

if (!function_exists('discountPercentage')) {
    // return discount in %
    function discountPercentage($product)
    {
        $discountPercentage = $product->discount_value;

        if ($product->discount_type != "percent") {
            $price = productBasePrice($product);
            $discountAmount = discountedProductBasePrice($product);
            $discountValue = $price - $discountAmount;
            $discountPercentage = ($discountValue * 100) / ($price > 0 ? $price : 1);
        }

        return round($discountPercentage);
    }
}

if (!function_exists('sellCountPercentage')) {
    // return sales count %
    function sellCountPercentage($product)
    {
        $sold = $product->total_sale_count;
        $target = (int) $product->sell_target;
        $salePercentage = ($sold * 100) / ($target > 0 ? $target : 1);
        return round($salePercentage);
    }
}

if (!function_exists('generateVariationOptions')) {
    //  generate combinations based on variations
    function generateVariationOptions($options)
    {
        if (count($options) == 0) {
            return $options;
        }
        $variation_ids = array();
        foreach ($options as $option) {

            $value_ids = array();
            if (isset($variation_ids[$option->variation_id])) {
                $value_ids = $variation_ids[$option->variation_id];
            }
            if (!in_array($option->variation_value_id, $value_ids)) {
                array_push($value_ids, $option->variation_value_id);
            }
            $variation_ids[$option->variation_id] = $value_ids;
        }
        $options = array();
        foreach ($variation_ids as $id => $values) {
            $variationValues = array();
            foreach ($values as $value) {
                $variationValue = VariationValue::find($value);
                $val = array(
                    'id'   => $value,
                    'name' => $variationValue->collectLocalization('name'),
                    'code' => $variationValue->color_code
                );
                array_push($variationValues, $val);
            }
            $data['id'] = $id;
            $data['name'] = Variation::find($id)->collectLocalization('name');
            $data['values'] = $variationValues;

            array_push($options, $data);
        }
        return $options;
    }
}

if (!function_exists('variationPrice')) {
    // return price of a variation
    function variationPrice($product, $variation)
    {
        $price = $variation->price;

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $price += ($price * $product_tax->tax_value) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $price += $product_tax->tax_value;
            }
        }
        return $price;
    }
}

if (!function_exists('variationDiscountedPrice')) {
    // return discounted price of a variation
    function variationDiscountedPrice($product, $variation, $addTax = true)
    {
        $price = $variation->price;

        // $discount_applicable = false;


        // if ($product->discount_start_date == null || $product->discount_end_date == null) {
        //     $discount_applicable = false;
        // } elseif (
        //     strtotime(date('d-m-Y H:i:s')) >= $product->discount_start_date &&
        //     strtotime(date('d-m-Y H:i:s')) <= $product->discount_end_date
        // ) {
        //     $discount_applicable = true;
        // }

        // if ($discount_applicable) {
        //     if ($product->discount_type == 'percent') {
        //         $price -= ($price * $product->discount_value) / 100;
        //     } elseif ($product->discount_type == 'flat') {
        //         $price -= $product->discount_value;
        //     }
        // }

        // if ($addTax) {
        //     foreach ($product->taxes as $product_tax) {
        //         if ($product_tax->tax_type == 'percent') {
        //             $price += ($price * $product_tax->tax_value) / 100;
        //         } elseif ($product_tax->tax_type == 'flat') {
        //             $price += $product_tax->tax_value;
        //         }
        //     }
        // }

        return $price;
    }
}

if (!function_exists('variationTaxAmount')) {
    // return tax of a variation
    function variationTaxAmount($product, $variation)
    {
        $price = $variation->price;
        $tax   = 0;

        foreach ($product->taxes as $product_tax) {
            if ($product_tax->tax_type == 'percent') {
                $tax += ($price * $product_tax->tax_value) / 100;
            } elseif ($product_tax->tax_type == 'flat') {
                $tax += $product_tax->tax_value;
            }
        }

        return $tax;
    }
}

if (!function_exists('getSubTotal')) {
    // return sub total price
    function getSubTotal($carts,$addTax = true)
    {
        $price = 0;
        if (count($carts) > 0) {
            foreach ($carts as $cart) {
                $product    = $cart->product_variation->product;
                $variation  = $cart->product_variation;
                $discountedVariationPriceWithTax = variationDiscountedPrice($product, $variation, $addTax);
                $price += (float) $discountedVariationPriceWithTax * $cart->qty;
            }
           
            if(!empty($carts) && sizeof($carts)>0) {

                foreach($carts as $cartItem) {
                  if(!empty($cartItem->addon_product_id)){
                      $addons= (array)(json_decode($cartItem->addon_product_id));
                      foreach($addons as $id=>$count) {
                        $cartAddons=AddOnProduct::isPublished()->where('id',$id)->first();
                        $price +=($cartAddons->price)*(int)($count);
                      }
                  }
                  
                }
            }
        }
      
        return $price;
    }
}

if (!function_exists('getTotalTax')) {
    // get Total Tax from
    function getTotalTax($carts)
    {
        $tax = 0;
        if ($carts) {

            foreach ($carts as $cart) {
                $product    = $cart->product_variation->product;
                $variation  = $cart->product_variation;

                $variationTaxAmount = variationTaxAmount($product, $variation);
                $tax += (float) $variationTaxAmount * $cart->qty;
            }
        }
        return $tax;
    }
}


if (!function_exists('paidPaymentStatus')) {
    // paid Payment Status
    function paidPaymentStatus()
    {
        return "paid";
    }
}
if (!function_exists('unpaidPaymentStatus')) {
    // unpaid Payment Status
    function unpaidPaymentStatus()
    {
        return "unpaid";
    }
}

if (!function_exists('orderPlacedStatus')) {
    // orderPlacedStatus
    function orderPlacedStatus()
    {
        return "order_placed";
    }
}
if (!function_exists('orderPendingStatus')) {
    // orderPendingStatus
    function orderPendingStatus()
    {
        return "pending";
    }
}
if (!function_exists('orderProcessingStatus')) {
    // orderProcessingStatus
    function orderProcessingStatus()
    {
        return "processing";
    }
}

// todo:: orderIsPickedUpStatus Order status
if (!function_exists('orderPickedUpStatus')) {
    // orderIsPickedUpStatus
    function orderPickedUpStatus()
    {
        return "picked_up";
    }
}

// todo:: OutForDelivery Order status
if (!function_exists('orderOutForDeliveryStatus')) {
    // orderProcessingStatus
    function orderOutForDeliveryStatus()
    {
        return "out_for_delivery";
    }
}

if (!function_exists('orderDeliveredStatus')) {
    // order Delivered Status
    function orderDeliveredStatus()
    {
        return "delivered";
    }
}

if (!function_exists('orderCancelledStatus')) {
    // order cancelled Status
    function orderCancelledStatus()
    {
        return "cancelled";
    }
}


if (!function_exists('getProductImage')) {
    function getProductImage($type, $id)
    {
        if($type==1){
            $product=Product::where('id',$id)->first();
            return $product;
        }
        else{
            $product=AddOnProduct::where('id',$id)->first();
            return $product;
        }
    }
}




    if (!function_exists('getCurrencySymbol')) {
        function getCurrencySymbol()
        {
            $symbol = Session::has('currency_symbol') ? Session::get('currency_symbol') : env('DEFAULT_CURRENCY_SYMBOL') ?? '₹';
            return $symbol;
        }
    }

    if (!function_exists('getPayableAmount')) {
        function getPayableAmount($carts)
        {
            $total = getSubTotal($carts, false, '', false) + getTotalTax($carts);
            $payAmount=0;

            $payStatus=getSetting('order_partial_status');
            $partialAmount=getSetting('order_partial_amount');

            if($payStatus=="On") {
                $payAmount=$total-$partialAmount;
            }

            
            return $payAmount;
        }
    }


    /*
type: numeric,alphabet,alpha_numeric,token
 */

  if (!function_exists('generate_random_token')) {

    function generate_random_token($type, $size)
    {

        $token = '';

        $alphabet = range("A", "Z");
        $numeric = range("1", "100");

        switch ($type) {
            case 'numeric':
                shuffle($numeric);
                $res = array_chunk($numeric, $size, true);
                $token = substr(implode('', $res[0]), 0, $size);
                break;
            case 'alphabet':
                shuffle($alphabet);
                $res = array_chunk($alphabet, $size, true);
                $token = substr(implode('', $res[0]), 0, $size);
                break;
            case 'alpha_numeric':
                $alphabet_num = array_merge($alphabet, $numeric);
                shuffle($alphabet_num);
                $res = array_chunk($alphabet_num, $size, true);
                $token = substr(implode('', $res[0]), 0, $size);
                break;
            case 'token':
                $alphabet_num = array_merge($alphabet, $numeric);
                shuffle($alphabet_num);
                $res = array_chunk($alphabet_num, $size, true);
                $token = substr(implode('', $res[0]), 0, $size);
                break;

            default:

                break;
        }

        return $token;
    }
 }




    function getUniqueValue($model, $column_name, $sizeArray,$slug = "",$status=false)
    {
        $generatedSlug='';
      
        if(!empty($slug)) {
            $generatedSlug.= Str::slug($slug);
        }   

        $model_location='';

        if (!empty($model_location)) {
            $model_location = "\\" . $model_location;
        }

        $modelpath = str_replace('"', "", 'App\Models' . $model_location . '\\' . $model);

        if($status==true) {

            $generatedSlug.= '-'.generate_random_token('alphabet', $sizeArray[0]) . generate_random_token('alpha_numeric', $sizeArray[1]);
        }

        $availabel = $modelpath::where($column_name, $generatedSlug)->first();
      
        if (!empty($availabel)) {
            return getUniqueValue($model, $column_name, $sizeArray,$slug,true);
        } else {
            
            return $generatedSlug;
        }
    }
 

