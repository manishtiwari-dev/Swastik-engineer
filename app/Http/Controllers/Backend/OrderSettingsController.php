<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ScheduledDeliveryTimeList;
use Illuminate\Http\Request;

class OrderSettingsController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:order_settings'])->only(['index', 'store', 'edit', 'update', 'delete']);
    }

    # order settings view
    public function index()
    {
        return view('backend.pages.systemSettings.orderSettings');
    }
}
