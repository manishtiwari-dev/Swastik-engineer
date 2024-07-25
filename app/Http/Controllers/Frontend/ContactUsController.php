<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactUsMessage;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    # store contact us form data
    public function store(Request $request)
    {   


        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ],
            [
                'name.required' => 'Please enter name.',
                'email.required' => 'Please enter email.',
                'email.email' => 'Please enter valid email.',
                'message' => 'Please enter message.',
            ]
        );

        $msg = new ContactUsMessage;
        $msg->name          = $request->name;
        $msg->email         = $request->email;
        $msg->phone         = $request->phone;
        $msg->message       = $request->message;
        $msg->save();
        flash(localize('Your message has been sent successfully'))->success();
        return back();
    }
}
