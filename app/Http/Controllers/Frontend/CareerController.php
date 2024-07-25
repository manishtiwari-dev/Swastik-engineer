<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Career;
use Flash;

class CareerController extends Controller
{
    # get states based on country
    public function index(Request $request)
    {
        return getView('pages.career');
    }


    public function store(Request $request)
    {


        $mediaFile = '';

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            // Get the current timestamp
            $timestamp = now()->timestamp;
            // Get the original file extension
            $extension = $file->getClientOriginalExtension();
    
            // Combine timestamp and extension to create a unique filename
            $fileName = $timestamp . '.' . $extension;
            // Store the file with the new filename
            $mediaFile = $file->storeAs('uploads/career', $fileName);
        }



        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'cover_letter' => 'required',
            ],
            [
                'name.required' => 'Please enter name.',
                'email.required' => 'Please enter email.',
                'email.email' => 'Please enter valid email.',
                'phone' => 'Please enter number.',  
                'cover_letter' => 'Please enter cover letter.',
            ]
        );

        $career = new Career;
        $career->name          = $request->name;
        $career->email         = $request->email;
        $career->phone         = $request->phone;
        $career->cover_letter       = $request->cover_letter;
        $career->attachment       = $mediaFile;
        $career->confirmation       = $request->confirmation ?? 0;
        $career->save();
        // Flash::success('Operation was successful!');



        flash(localize('Your Application Submit successfully'))->success();
        return back();
    }




}
