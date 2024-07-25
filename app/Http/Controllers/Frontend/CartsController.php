<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;

use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Auth;
use App\Models\AddOnProduct;

class CartsController extends Controller
{
    

    # all cart items
    public function index(Request $request)
    {   
        $carts = null;
        $carts = Cart::where('session_id',$request->cookie('XSRF-TOKEN'))->get();
        
        $addOnArray=[];

        if(!empty($carts) && sizeof($carts)>0) {

          foreach($carts as $cartItem) {
            if(!empty($cartItem->addon_product_id)){

                $addons= (array)(json_decode($cartItem->addon_product_id));
                $ids=array_keys($addons);
                $addOnArray=array_merge($addOnArray,$ids);
               
                $cartAddons=AddOnProduct::isPublished()->whereIn('id',$ids)->get();
            
                $cartItem->AddOnProducts=$cartAddons;
            }
          }
        }
    
        $AddOnProducts = AddOnProduct::isPublished()->get();
        
        return getView('pages.carts', ['carts' => $carts,'addOnArray'=>$addOnArray,'AddOnProducts'=>$AddOnProducts]);
    }

    # add to cart
    public function store(Request $request)
    {    
        
        $productVariation = ProductVariation::where('id', $request->variation_id)->first();

        if (!is_null($productVariation)) {

            $cart = null;
            $message = '';

            $cartExist = Cart::where(['session_id' => $request->cookie('XSRF-TOKEN')])->first();
            if(!empty($cartExist))
            $cartExist->delete();

            $addOns=AddOnProduct::isPublished()->get();

            $addOnArray=[];

            if(!empty($addOns)) {

                foreach($addOns as $addonProduct){
                        if(!empty($request->{'addon_product_'.$addonProduct->id})) {
                        $addOnArray[$addonProduct->id]=$request->{'addon_qty_'.$addonProduct->id};
                        }
                }
            }

            $cart = new Cart;
            $cart->product_variation_id = $productVariation->id;
            $cart->qty                  = (int) $request->quantity;
            $cart->product_id           =  $request->product_id;
            $cart->message              =  $request->message;
            $cart->addon_product_id     =  json_encode($addOnArray);
            
            $attributes=['eggless'=>$request->eggless ?? 0 ,'heartshape'=>$request->heartshape ?? 0];

            $cart->attributes  = json_encode($attributes);

            $cart->session_id = $request->cookie('XSRF-TOKEN');
            
            $message =  flash(localize('Product added to your cart'))->error();
            
            $cart->save();
        
            return redirect()->route('checkout.proceed');
        }
    }

    # update cart
    public function update(Request $request)
    {
        try {
            $cart = Cart::where('id', $request->id)->first();
            if ($request->action == "increase") {
                $cart->qty += 1;
                $cart->save();
            } elseif ($request->action == "decrease") {
                if ($cart->qty > 1) {
                    $cart->qty -= 1;
                    $cart->save();
                }
            } else {
                $cart->delete();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        return $this->getCartsInfo('Cart Updated SuccessFully.');
    }

   

    # get cart information
    private function getCartsInfo($message = '')
    {
        
        $carts = Cart::where('session_id',$_COOKIE('XSRF-TOKEN'))->get();
        
        return [
            'success'           => true,
            'message'           => $message,
            'carts'             => getViewRender('pages.partials.carts.cart-listing', ['carts' => $carts]),
            'navCarts'          => getViewRender('pages.partials.carts.cart-navbar', ['carts' => $carts]),
            'cartCount'         => count($carts),
            'subTotal'          => formatPrice(getSubTotal($carts)),
            'couponDiscount'    => formatPrice(getCouponDiscount(getSubTotal($carts, false))),
        ];
    }
}
