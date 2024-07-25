<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\MediaManager;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:homepage'])->only(['hero', 'edit', 'delete']);
    }

    # get the sliders
    private function getSliders()
    {
        $sliders = [];

        if (getSetting('hero_sliders') != null) {
            $sliders = json_decode(getSetting('hero_sliders'));
        }
        return $sliders;
    }

    # homepage hero configuration
    public function hero()
    {   
        $locale='';
        if (env('DEFAULT_LANGUAGE')) {
            $locale = env('DEFAULT_LANGUAGE');
        } else{
            $locale="en"; 
        }

        $sliders = $this->getSliders();
        return view('backend.pages.appearance.homepage.hero', compact('sliders','locale'));
    }

    # store homepage hero configuration
    public function storeHero(Request $request)
    {
        $sliderImage = SystemSetting::where('entity', 'hero_sliders')->first();

        if (!is_null($sliderImage)) {
            if (!is_null($sliderImage->value) && $sliderImage->value != '') {
                $sliders            = json_decode($sliderImage->value);
                $newSlider          = new MediaManager; //temp obj
                $newSlider->id      = rand(100000, 999999);
                $newSlider->title   = $request->title ? $request->title : '';
                $newSlider->description       = $request->description ? $request->description : '';
                $newSlider->button_name        = $request->button_name ? $request->button_name : '';
                $newSlider->link        = $request->link ? $request->link : '';
                $newSlider->status        = $request->status ? $request->status : 0;
                $newSlider->mobile_image       = $request->mobile_image ? $request->mobile_image : '';
                $newSlider->desktop_image       = $request->desktop_image ? $request->desktop_image : '';
                

                array_push($sliders, $newSlider);
                $sliderImage->value = json_encode($sliders);
                $sliderImage->save();
            } else {
                $value                  = [];
                $newSlider              = new MediaManager; //temp obj
                $newSlider->id          = rand(100000, 999999);
                $newSlider->title    = $request->title ? $request->title : '';
                $newSlider->description       = $request->description ? $request->description : '';
                $newSlider->button_name        = $request->button_name ? $request->button_name : '';
                $newSlider->link        = $request->link ? $request->link : '';
                $newSlider->status        = $request->status ? $request->status : 0;
                $newSlider->mobile_image       = $request->mobile_image ? $request->mobile_image : '';
                $newSlider->desktop_image       = $request->desktop_image ? $request->desktop_image : '';

                array_push($value, $newSlider);
                $sliderImage->value = json_encode($value);
                $sliderImage->save();
            }
        } else {
            $sliderImage = new SystemSetting;
            $sliderImage->entity = 'hero_sliders';

            $value              = [];
            $newSlider          = new MediaManager; //temp obj
            $newSlider->id      = rand(100000, 999999);
            $newSlider->title   = $request->title ? $request->title : '';
            $newSlider->description       = $request->description ? $request->description : '';
            $newSlider->button_name        = $request->button_name ? $request->button_name : '';
            $newSlider->link        = $request->link ? $request->link : '';
            $newSlider->status        = $request->status ? $request->status : 0;
            $newSlider->mobile_image       = $request->mobile_image ? $request->mobile_image : '';
            $newSlider->desktop_image       = $request->desktop_image ? $request->desktop_image : '';

            array_push($value, $newSlider);
            $sliderImage->value = json_encode($value);
            $sliderImage->save();
        }
        cacheClear();
        flash(localize('Slider image added successfully'))->success();
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
         
        $sliders = $this->getSliders();
        return view('backend.pages.appearance.homepage.heroEdit', compact('sliders', 'id','locale'));
    }

    # update hero slider
    public function update(Request $request)
    {
        $sliderImage = SystemSetting::where('entity', 'hero_sliders')->first();

        $sliders = $this->getSliders();
        $tempSliders = [];

        foreach ($sliders as $slider) {
            if ($slider->id == $request->id) {
                $slider->title   = $request->title ? $request->title : '';
                $slider->description       = $request->description ? $request->description : '';
                $slider->button_name        = $request->button_name ? $request->button_name : '';
                $slider->link        = $request->link ? $request->link : '';
                $slider->status        = $request->status ? $request->status : 0;
                $slider->mobile_image       = $request->mobile_image ? $request->mobile_image : '';
                $slider->desktop_image       = $request->desktop_image ? $request->desktop_image : '';
                array_push($tempSliders, $slider);
            } else {
                array_push($tempSliders, $slider);
            }
        }

        $sliderImage->value = json_encode($tempSliders);
        $sliderImage->save();
        cacheClear();
        flash(localize('Slider updated successfully'))->success();
        return redirect()->route('admin.appearance.homepage.hero');
    }

    # delete hero slider
    public function delete($id)
    {
        $sliderImage = SystemSetting::where('entity', 'hero_sliders')->first();

        $sliders = $this->getSliders();
        $tempSliders = [];

        foreach ($sliders as $slider) {
            if ($slider->id != $id) {
                array_push($tempSliders, $slider);
            }
        }

        $sliderImage->value = json_encode($tempSliders);
        $sliderImage->save();

        cacheClear();
        flash(localize('Slider deleted successfully'))->success();
        return redirect()->route('admin.appearance.homepage.hero');
    }
}
