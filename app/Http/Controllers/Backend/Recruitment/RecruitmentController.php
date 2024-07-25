<?php

namespace App\Http\Controllers\Backend\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;



class RecruitmentController extends Controller
{
      # construct
      public function __construct()
      {
          $this->middleware(['permission:human_resources'])->only('index');
      }

      public function index(Request $request)
      {
        $applications = Career::orderBy('is_seen', 'ASC')->latest()->paginate(paginationNumber());
        
        return view('backend.pages.recruitment.index', compact('applications'));
      }


      # make message read

      public function read($id)
      {
          $message = Career::where('id', $id)->first();

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