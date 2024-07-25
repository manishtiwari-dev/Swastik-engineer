<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;

class PageController extends Controller
{
    # get states based on country
    public function index(Request $request,$slug)
    {
        $page_data=Page::where('slug',$slug)->first();
        return getView('pages.dyanamic_page', ['page_data'=>$page_data]);
    }
}
