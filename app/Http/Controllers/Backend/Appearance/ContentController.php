<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\MediaManager;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:homepage'])->only(['hero', 'edit', 'delete']);
    }

    # get the contents
    private function getContents()
    {
        $contents = [];

        if (getSetting('home_page_contents') != null) {
            $contents = json_decode(getSetting('home_page_contents'));
        }
        return $contents;
    }

    # homepage certificate configuration

    public function contents()
    {   
        $locale='';
        if (env('DEFAULT_LANGUAGE')) {
            $locale = env('DEFAULT_LANGUAGE');
        } else{
            $locale="en"; 
        }
        
        $contentObj='';

        $content = $this->getContents();

        if(!empty($content) && sizeof($content)>0)
            $contentObj=$content[0];
        

        return view('backend.pages.appearance.homepage.content', compact('contentObj','locale'));
    }

    # store homepage hero configuration

    public function storeContent(Request $request)
    {   
        $homePageContent = SystemSetting::where('entity', 'home_page_contents')->first();
       
        if (!is_null($homePageContent)) {

            if (!is_null($homePageContent->value) && $homePageContent->value != '') {

                $HomeContents       = json_decode($homePageContent->value);
                $newContent          = new MediaManager; //temp obj
                $newContent->id      = rand(100000, 999999);
                $newContent->abount_us_title   = $request->abount_us_title ? $request->abount_us_title : '';
                $newContent->abount_us_experience   = $request->abount_us_experience ? $request->abount_us_experience : '';
                $newContent->about_us_html   = $request->about_us_html ? $request->about_us_html : '';
                $newContent->about_us_image  = $request->about_us_image ? $request->about_us_image : '';
                
                $newContent->our_strength_title   = $request->our_strength_title ? $request->our_strength_title : '';
                $newContent->our_strength_html  = $request->our_strength_html ? $request->our_strength_html : '';

                array_push($HomeContents, $newContent);
                $homePageContent->value = json_encode($HomeContents);
                $homePageContent->save();

            } else {

                $value                  = [];
                $newContent          = new MediaManager; //temp obj
                $newContent->id      = rand(100000, 999999);
                $newContent->abount_us_title   = $request->abount_us_title ? $request->abount_us_title : '';
                $newContent->abount_us_experience   = $request->abount_us_experience ? $request->abount_us_experience : '';
                $newContent->about_us_html   = $request->about_us_html ? $request->about_us_html : '';
                $newContent->about_us_image  = $request->about_us_image ? $request->about_us_image : '';
                
                $newContent->our_strength_title   = $request->our_strength_title ? $request->our_strength_title : '';
                $newContent->our_strength_html  = $request->our_strength_html ? $request->our_strength_html : '';

                array_push($value, $newContent);
                $newContent->value = json_encode($value);
                $newContent->save();
            }

        } else {

            $content = new SystemSetting;
            $content->entity = 'home_page_contents';

            $value              = [];
            $newContent          = new MediaManager; //temp obj
            $newContent->id      = rand(100000, 999999);
            $newContent->abount_us_title   = $request->abount_us_title ? $request->abount_us_title : '';
            $newContent->abount_us_experience   = $request->abount_us_experience ? $request->abount_us_experience : '';
            $newContent->about_us_html   = $request->about_us_html ? $request->about_us_html : '';
            $newContent->about_us_image  = $request->about_us_image ? $request->about_us_image : '';
            
            $newContent->our_strength_title   = $request->our_strength_title ? $request->our_strength_title : '';
            $newContent->our_strength_html  = $request->our_strength_html ? $request->our_strength_html : '';

            array_push($value, $newContent);
            $content->value = json_encode($value);
            $content->save();
        }
        cacheClear();
        flash(localize('Home page content added successfully'))->success();
        return back();
    }

    # edit hero slider
    public function edit($id)
    {   
        $locale='';
        if (env('DEFAULT_LANGUAGE')) {
            $locale = env('DEFAULT_LANGUAGE');
        } else{
            $locale="en"; 
         }
         
        $certificates = $this->getContents();

        
        return view('backend.pages.appearance.homepage.certificateEdit', compact('certificates', 'id','locale'));
    }

    # update hero slider
    public function update(Request $request)
    {
        $content = SystemSetting::where('entity', 'home_page_contents')->first();
        
        $contents = $this->getContents();
        $tempContents = [];

        foreach ($contents as $ContentData) {

            if ($ContentData->id == $request->id) {

                $ContentData->abount_us_title   = $request->abount_us_title ? $request->abount_us_title : '';
                $ContentData->abount_us_experience   = $request->abount_us_experience ? $request->abount_us_experience : '';
                $ContentData->about_us_html   = $request->about_us_html ? $request->about_us_html : '';
                $ContentData->about_us_image  = $request->about_us_image ? $request->about_us_image : '';
                
                $ContentData->our_strength_title   = $request->our_strength_title ? $request->our_strength_title : '';
                $ContentData->our_strength_html  = $request->our_strength_html ? $request->our_strength_html : '';
               
                array_push($tempContents, $ContentData);
            } else {
                array_push($tempContents, $ContentData);
            }
        }

        $content->value = json_encode($tempContents);
        $content->save();
        cacheClear();
        flash(localize('Slider updated successfully'))->success();
        return redirect()->route('admin.appearance.homepage.content');
    }

    # delete hero slider
    public function delete($id)
    {
        $certificate = SystemSetting::where('entity', 'certificates')->first();

        $sliders = $this->getContents();
        $tempCertificate = [];

        foreach ($sliders as $slider) {
            if ($slider->id != $id) {
                array_push($tempCertificate, $slider);
            }
        }

        $certificate->value = json_encode($tempCertificate);
        $certificate->save();

        cacheClear();
        flash(localize('Slider deleted successfully'))->success();
        return redirect()->route('admin.appearance.homepage.certificate');
    }
}
