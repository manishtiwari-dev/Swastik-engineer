<?php

namespace App\Http\Controllers\Backend\Orders;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Location;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PDF;


class OrdersController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:orders'])->only('index');
        $this->middleware(['permission:manage_orders'])->only(['show', 'updatePaymentStatus', 'updateDeliveryStatus', 'downloadInvoice']);
    }

    # get all orders
    public function index(Request $request)
    {
        $searchKey = null;
        $searchCode = null;
        $orderStatus = null;
        $paymentStatus = null;
        
        $orders = Order::latest();
      
        # conditional 
        if ($request->search != null) {
            $searchKey = $request->search;
            $orders = $orders->where(function ($q) use ($searchKey) {
                $customers = User::where('name', 'like', '%' . $searchKey . '%')
                    ->orWhere('phone', 'like', '%' . $searchKey)
                    ->pluck('id');
                $q->orWhereIn('user_id', $customers);
            });
        }

        if ($request->code != null) {
            $searchCode = $request->code;
            $orders = $orders->where('order_code',$searchCode);
        }

        if ($request->order_status != null) {
            $orderStatus = $request->order_status;
            $orders = $orders->where('order_status', $orderStatus);
        }

        if ($request->payment_status != null) {
            $paymentStatus = $request->payment_status;
            $orders = $orders->where('payment_status', $paymentStatus);
        }

        $orders = $orders->paginate(paginationNumber());

        return view('backend.pages.orders.index', compact('orders', 'searchKey', 'searchCode', 'orderStatus', 'paymentStatus'));
    }

    # show order details
    public function show($id)
    {
        $order = Order::find($id);
        return view('backend.pages.orders.show', compact('order'));
    }

    # update payment status 
    public function updatePaymentStatus(Request $request)
    {
        $order = Order::findOrFail((int)$request->order_id);
        $order->payment_status = $request->status;
        $order->save();
        $note='';

        switch($order->payment_status){
        case(0):
            $note='Payment status updated to ' .localize('Failed');
            break;
        case(1):
            $note='Payment status updated to ' .localize('Unpaid');
            break;
        case(2):
            $note='Payment status updated to ' .localize('Paid');
            break;
        }

        OrderUpdate::create([
            'order_id' => $order->order_id,
            'note' => $note . '.',
        ]);

        // todo::['mail notification']
        return true;
    }

    # update delivery status
    public function updateOrderStatus(Request $request)
    {
        $order = Order::findOrFail((int)$request->order_id);
        $order->order_status = $request->status;
        $order->save();

        $status='';

        switch($order->order_status){
        case(1):
            $status='Delivery status updated to ' .localize('Deliverd') ;
            break;
        case(2):
            $status='Delivery status updated to ' .localize('Cancelled') ;
            break;
        case(3):
            $status='Delivery status updated to ' .localize('Placed') ;
            break;
        case(4):
            $status='Delivery status updated to ' .localize('Failed') ;
            break;
        case(5):
            $status='Delivery status updated to ' .localize('Pending') ;
            break;           
        }

        OrderUpdate::create([
            'order_id' => $order->order_id,
            'note' => $status.'.',
        ]);

        // todo::['mail notification'] 
        return true;
    }

 



    # download invoice
    public function downloadInvoice($id)
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

        $order = Order::findOrFail((int)$id);
       
        return PDF::loadView('backend.pages.orders.invoice', [
            'order' => $order,
            'font_family' => $font_family,
            'direction' => $direction,
            'default_text_align' => $default_text_align,
            'reverse_text_align' => $reverse_text_align
        ], [], [])->download(getSetting('order_code_prefix') . $order->order_code . '.pdf');
    }



}
