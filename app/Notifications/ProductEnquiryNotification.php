<?php

namespace App\Notifications;

use App\Models\Language;
use App\Models\Product;
use App\Models\ProductEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Config;


class ProductEnquiryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $productEnquiry;

    public function __construct(ProductEnquiry $productEnquiry)
    {
        $this->productEnquiry = $productEnquiry;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {   

        $sender_email = env('ADMIN_MAIL_ADDRESS') ?? 'admin@swastikengineers.com';
        $sender_name = "Swastik Engineers";

        $product = Product::where('id', $this->productEnquiry->product_id)->first();

        $product_name=$product->name ?? '';

        $htmlMessage = 'New enquiry for '.$product_name.'received';

        $emailContent= (new MailMessage)
        ->greeting('Hello Sir!')
        ->line('New Enquiry has been generated on website')
        ->salutation(" ")
        ->subject($htmlMessage)
        ->from($sender_email,$sender_name);

        $enqData=$this->productEnquiry;

        if(!empty($product_name))
            $emailContent = $emailContent->line('Product name'. ' : ' . $product_name ?? 'n/a');

        if(!empty(($enqData->name)))
            $emailContent = $emailContent->line('Customer Name'. ' : ' . $enqData->name ?? 'n/a');

        if(!empty(($enqData->email)))
            $emailContent = $emailContent->line('Email'. ' : ' . $enqData->email ?? 'n/a');

        if(!empty(($enqData->phone)))
            $emailContent = $emailContent->line('Phone'. ' : ' . $enqData->phone ?? 'n/a');

        if(!empty($enqData->message))
            $emailContent = $emailContent->line('Message'. ' : ' . $enqData->message ?? 'n/a');

        return $emailContent;

    }

    public function toArray($notifiable)
    {
        return [
            'data' => $notifiable->toArray()
        ];
    }
}
