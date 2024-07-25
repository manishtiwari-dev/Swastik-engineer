<?php

namespace App\Http\Controllers\Backend\Enquiries;

use App\Http\Controllers\Controller;
use App\Models\ProductEnquiry;

class ProductEnquiryController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:product_enquiries'])->only('index');
    }

    # get all query messages
    public function index()
    {
        $messages = ProductEnquiry::with('product')->orderBy('is_seen', 'ASC')->latest()->paginate(paginationNumber());
       
        return view('backend.pages.enquiry.index', compact('messages'));
    }

    # make message read
    public function read($id)
    {
        $message = ProductEnquiry::where('id', $id)->first();

        if ($message->is_seen == 0) {
            $message->is_seen = 1;
            flash(localize('Marked as read'))->success();
        } else {
            $message->is_seen = 0;
            flash(localize('Marked as unread'))->success();
        }
        $message->save();
        return back();
    }
}
