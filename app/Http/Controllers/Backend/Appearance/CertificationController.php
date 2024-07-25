<?php

namespace App\Http\Controllers\Backend\Appearance;

use App\Http\Controllers\Controller;
use App\Models\MediaManager;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    # construct
    public function __construct()
    {
        $this->middleware(['permission:homepage'])->only(['hero', 'edit', 'delete']);
    }

    # get the sliders
    private function getCertificates()
    {
        $sliders = [];

        if (getSetting('certificates') != null) {
            $sliders = json_decode(getSetting('certificates'));
        }
        return $sliders;
    }

    # homepage certificate configuration

    public function certificates()
    {   
        $locale='';
        if (env('DEFAULT_LANGUAGE')) {
            $locale = env('DEFAULT_LANGUAGE');
        } else{
            $locale="en"; 
        }

        $certificates = $this->getCertificates();
        return view('backend.pages.appearance.homepage.certificate', compact('certificates','locale'));
    }

    # store homepage hero configuration

    public function storeCertificate(Request $request)
    {
        $certificatesImage = SystemSetting::where('entity', 'certificates')->first();
       
        if (!is_null($certificatesImage)) {
            if (!is_null($certificatesImage->value) && $certificatesImage->value != '') {

                $certificates       = json_decode($certificatesImage->value);
                $newCertificate          = new MediaManager; //temp obj
                $newCertificate->id      = rand(100000, 999999);
                $newCertificate->title   = $request->title ? $request->title : '';
                $newCertificate->image   = $request->image ? $request->image : '';
                $newCertificate->status  = $request->status ? $request->status : 0;
                
                array_push($certificates, $newCertificate);
                $certificatesImage->value = json_encode($certificates);
                $certificatesImage->save();

            } else {
                $value                  = [];
                $newCertificate          = new MediaManager; //temp obj
                $newCertificate->id      = rand(100000, 999999);
                $newCertificate->title   = $request->title ? $request->title : '';
                $newCertificate->image   = $request->image ? $request->image : '';
                $newCertificate->status  = $request->status ? $request->status : 0;

                array_push($value, $newCertificate);
                $newCertificate->value = json_encode($value);
                $newCertificate->save();
            }
        } else {
            $certificate = new SystemSetting;
            $certificate->entity = 'certificates';

            $value              = [];
            $newCertificate          = new MediaManager; //temp obj
            $newCertificate->id      = rand(100000, 999999);
            $newCertificate->title   = $request->title ? $request->title : '';
            $newCertificate->image   = $request->image ? $request->image : '';
            $newCertificate->status  = $request->status ? $request->status : 0;

            array_push($value, $newCertificate);
            $certificate->value = json_encode($value);
            $certificate->save();
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
         
        $certificates = $this->getCertificates();
        return view('backend.pages.appearance.homepage.certificateEdit', compact('certificates', 'id','locale'));
    }

    # update hero slider
    public function update(Request $request)
    {
        $certificate = SystemSetting::where('entity', 'certificates')->first();

        $certificates = $this->getCertificates();
        $tempCertificates = [];

        foreach ($certificates as $certificateData) {

            if ($certificateData->id == $request->id) {
                $certificateData->title   = $request->title ? $request->title : '';
                $certificateData->image       = $request->image ? $request->image : '';
                $certificateData->status        = $request->status ? $request->status : 0;
               
                array_push($tempCertificates, $certificateData);
            } else {
                array_push($tempCertificates, $certificateData);
            }
        }

        $certificate->value = json_encode($tempCertificates);
        $certificate->save();
        cacheClear();
        flash(localize('Slider updated successfully'))->success();
        return redirect()->route('admin.appearance.homepage.certificate');
    }

    # delete hero slider
    public function delete($id)
    {
        $certificate = SystemSetting::where('entity', 'certificates')->first();

        $sliders = $this->getCertificates();
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
