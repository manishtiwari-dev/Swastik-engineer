<?php

namespace App\Notifications;

use App\Models\Language;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;


class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $array['subject'] = localize('Your order has been placed') . ' - ' . $this->order->order_code;
        $array['order'] = $this->order;


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

        return (new MailMessage)
            ->view('backend.pages.orders.invoice', [
                'order' => $this->order,
                'font_family' => $font_family,
                'direction' => $direction,
                'default_text_align' => $default_text_align,
                'reverse_text_align' => $reverse_text_align
            ])
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject(localize('Order Placed') . ' - ' . env('APP_NAME'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
