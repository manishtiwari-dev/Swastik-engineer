<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Backend\Payments\PaymentsController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Validation\ValidationException;
use App\Notifications\OrderPlacedNotification;
use Illuminate\Http\Request;
use Notification;
use Config;
use Session;
use App\Models\AddOnProduct;
use App\Models\Language;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Hash;
use PDF;
use App\Http\Services\SmsServices;
use App\Models\OrderUpdate;
use Illuminate\Support\Facades\Validator;



class CheckoutController extends Controller
{
    # checkout
    public function index(Request $request)
    {   
        $carts = Cart::where('session_id',$request->cookie('XSRF-TOKEN'))->get();
        $countries = Country::isActive()->get();
        

        if(!empty($carts) && sizeof($carts)>0) {

            foreach($carts as $cartItem) {
              if(!empty($cartItem->addon_product_id)){

                  $addons= (array)(json_decode($cartItem->addon_product_id));
                  $ids=array_keys($addons);
                
                  $cartAddons=AddOnProduct::isPublished()->whereIn('id',$ids)->get();
  
                  $cartItem->AddOnProducts=$cartAddons;
                  $cartItem->addons=$addons;
              }
            }
        }

        return getView('pages.checkout', [
            'carts'     => $carts,
            'countries' => $countries,
        ]);
    }

   
    # complete checkout process
    public function complete(Request $request)
    {   
        #Validations
     
        $request->validate([
            'payment_method' => 'required',
            'customer_name' => 'required',
            'customer_email' => 'nullable|email',
            'customer_phone' => 'required',
          ],
            [
                'payment_method.required' => localize('Please select payment mode.'),
                'customer_name.required' => localize('Please enter customer name.'),
                'customer_email.required' => localize('Please enter email.'),
                'customer_email.email' => localize('Please enter valid email.'),
                'customer_phone.required' => localize('Please enter phone number.'),
            ]
        );


        if(!empty($request->partially_input) && $request->partially_input < getSetting('order_partial_amount')) {
            throw ValidationException::withMessages([
                'price' => "Please enter minimum amount.",
            ]);
        }

        $carts  = Cart::where('session_id',$request->cookie('XSRF-TOKEN'))->get();
      
        if (count($carts) > 0) {

            $res = User::where(['phone' => $request->customer_phone])->first();

            if (empty($res)) {

                $user=User::create([
                    'user_type'=>'customer',
                    'name'=>$request->customer_name,
                    'email'=>strtolower($request->customer_email ?? ''),
                    'phone'=>$request->customer_phone,
                    'password'=>Hash::make(rand(100000,500000)),
                ]);

            } else{
                $user=$res;
            }
            
            $userId                 = $user->id;
            
            # Store Customer Address
            $address                = new UserAddress;
            $address->user_id       = $userId;
            $address->name          = $request->customer_name ?? '';
            // $address->country_id    = $request->customer_country ?? '';
            // $address->state         = $request->customer_state ?? '';
            // $address->city          = $request->customer_city ?? '';
            $address->address       = $request->customer_address ?? '';
            $address->phone         = $request->customer_phone;
            // $address->pincode       = $request->customer_pincode ?? '';

            $address->save();
        

            # create new order 
            $Order                                     = new Order;
            $Order->user_id                            = $userId;
            $Order->address_id                         = $address->id;
            $Order->phone_no                           = $request->customer_phone;
            $Order->sub_total_amount                   = getSubTotal($carts, false, '', false);
            $Order->total_tax_amount                   = getTotalTax($carts);
            $Order->grand_total_amount                 = getSubTotal($carts, false, '', false) + getTotalTax($carts);
            $Order->payment_method                     = $request->payment_method;
            $Order->delivery_type                      = $request->deliveryType;
            $Order->order_note                         = $request->order_note;

            if(!empty($request->parse_payment) && $request->parse_payment=="part_payment"){

                $Order->payment_status = 3;

                $Order->paid_amount = $request->partially_input ?? 0;
                $Order->pending_amount =$Order->grand_total_amount - $Order->paid_amount;

            }

            $Order->save();


            # order items
            $total_points = 0;
            foreach ($carts as $cart) {

                $orderItem                       = new OrderItem;
                $orderItem->order_id             = $Order->order_id;
                $orderItem->product_id           = $cart->product_id;
                $orderItem->product_name         = $cart->product_variation->product->collectLocalization('name');
                $orderItem->product_type         = 1;
                $orderItem->product_variation    = $cart->product_variation->code;
                $orderItem->order_attributes     = $cart->attributes;
                $orderItem->qty                  = $cart->qty;
                $orderItem->order_message        = $cart->message;
                $orderItem->unit_price           = variationDiscountedPrice($cart->product_variation->product, $cart->product_variation);
                $orderItem->total_tax            = variationTaxAmount($cart->product_variation->product, $cart->product_variation);
                $orderItem->total_price          = $orderItem->unit_price * $orderItem->qty;    
                $orderItem->save();

                 // Update For Main Product

                 $product = $cart->product_variation->product;
                 $product->total_sale_count += $cart->qty;
                 $product->save();

                if(!empty($cart->addon_product_id)){

                    $addons= (array)(json_decode($cart->addon_product_id));
                    $ids=array_keys($addons);

                    $cartAddons=AddOnProduct::isPublished()->whereIn('id',$ids)->get();
                    
                    if(!empty($cartAddons)){

                        foreach($cartAddons as $addOnProduct) {

                            $orderItem                       = new OrderItem;
                            $orderItem->order_id             = $Order->order_id;
                            $orderItem->product_name         = $addOnProduct->collectLocalization('name');
                            $orderItem->product_type         = 2;
                            $orderItem->unit_price           = $addOnProduct->price;
                            $orderItem->total_price          = ($addOnProduct->price)*($addons[$addOnProduct->id]);
                            $orderItem->product_id           = $addOnProduct->id;
                            $orderItem->qty                  = $addons[$addOnProduct->id];
                            $orderItem->save(); 

                            // Update For Main AddOn Product

                            $addOnProductCount=AddOnProduct::where('id',$addOnProduct->id)->first();
                            $addOnProductCount->total_sale_count = $addOnProductCount->total_sale_count + 1;
                            $addOnProductCount->save();

                        }
                    }
                }
                
                // $cart->delete();
            }

            $order = Order::where('order_code', $Order->order_code)->first();

            try {

                $user=$order->user()->first();
                
                OrderUpdate::create([
                    'order_id' => $order->order_id,
                    'note' => 'Order Created.',
                ]);
                
                if(!empty($user->email))
                    Notification::send($user, new OrderPlacedNotification($order));
                
               // Send Mail Notification to admin
               $message="";
               $message.="New Order Received In Ibake.\n";
               $message.="Thank You";
               SmsServices::SendSMS(getSetting('order_contact_number'),$message); #To Admin
                // SmsServices::SendSMS($order->phone_no,$message); #To Customer
                
            } catch (\Exception $e) {
                // dd($e->getMessage());
            }



            
            # payment gateway integration & redirection

            $Order->payment_method = $request->payment_method;
            $Order->save();

            if ($request->payment_method != "cod") {
                $request->session()->put('payment_type', 'order_payment');
                $request->session()->put('order_code', $Order->order_code);
                $request->session()->put('payment_method', $request->payment_method);

                # init payment
                $payment = new PaymentsController;
                
                return $payment->initPayment();

            } else {
                
                if(empty($request->parse_payment) && $request->parse_payment!="part_payment")
                $Order->payment_status = 1;

                $Order->order_status = 5;
                $Order->save();

                flash(localize('Your order has been placed successfully'))->success();
                 
                return redirect()->route('checkout.success', $Order->order_code);
            }
        }

        flash(localize('Your cart is empty'))->error();
        return redirect()->route('home');
    }

    # order successful
    public function success($code)
    {
        $order = Order::where('order_code', $code)->first();
       
        if(empty($order))
            return redirect()->route('home');
        // todo:: change this from here
    
        return getView('pages.order_thanks', ['order' => $order]);
    }


    # order invoice
    public function invoice($code)
    {   
        if (session()->has('locale')) {
            $language_code = session()->get('locale', Config::get('app.locale'));
        } else {
            $language_code = env('DEFAULT_LANGUAGE') ?? Config::get('app.locale');
        }
   
        if (session()->has('currency_code')) {
            $currency_code = session()->get('currency_code', Config::get('app.currency_code'));
        } else {
            $currency_code = env('DEFAULT_CURRENCY') ?? Config::get('app.currency_code');
        }
       
        if (Language::where('code', $language_code)->first()->is_rtl == 1) {
            $direction = 'rtl';
            $default_text_align = 'right';
            $reverse_text_align = 'left';
        } else {
            $direction = 'ltr';
            $default_text_align = 'left';
            $reverse_text_align = 'right';
        }

        if ($currency_code == 'BDT' || $currency_code == 'bdt' || $language_code == 'bd' || $language_code == 'bn') {
            # bengali font
            $font_family = "'Hind Siliguri','sans-serif'";
        } elseif ($currency_code == 'KHR' || $language_code == 'kh') {
            # khmer font
            $font_family = "'Khmeros','sans-serif'";
        } elseif ($currency_code == 'AMD') {
            # Armenia font
            $font_family = "'arnamu','sans-serif'";
        } elseif ($currency_code == 'AED' || $currency_code == 'EGP' || $language_code == 'sa' || $currency_code == 'IQD' || $language_code == 'ir') {
            # middle east/arabic font
            $font_family = "'XBRiyaz','sans-serif'";
        } else {
            # general for all
            $font_family = "'Roboto','sans-serif'";
        }

        $order = Order::where('order_code',$code)->first();
       
        return PDF::loadView('backend.pages.orders.invoice', [
            'order' => $order,
            'font_family' => $font_family,
            'direction' => $direction,
            'default_text_align' => $default_text_align,
            'reverse_text_align' => $reverse_text_align
        ], [], [])->download(getSetting('order_code_prefix') . $order->order_code . '.pdf');
    }

    # update payment status
    public function updatePayments($payment_details)
    {
        $orderGroup = OrderGroup::where('order_code', session('order_code'))->first();
        $payment_method = session('payment_method');

        $orderGroup->payment_status = paidPaymentStatus();
        $orderGroup->order->update(['payment_status' => paidPaymentStatus()]); # for multi-vendor loop through each orders & update

        $orderGroup->payment_method = $payment_method;
        $orderGroup->payment_details = $payment_details;
        $orderGroup->save();

        clearOrderSession();
        flash(localize('Your order has been placed successfully'))->success();
        return redirect()->route('checkout.success', $orderGroup->order_code);
    }
}
