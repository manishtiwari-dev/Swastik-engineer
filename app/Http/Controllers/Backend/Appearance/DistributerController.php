<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\Brand;

class DistributerController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:homepage'])->only('index');
    }

    # best deal products
    public function index()
    {
        $distributers = Brand::isActive()->get();
        return view('backend.pages.appearance.homepage.distributers', compact('distributers'));
    }
}
