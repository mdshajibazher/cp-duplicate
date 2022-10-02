<?php

namespace App\Http\Controllers;

use App\Company;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CompanyController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('permission:company_info.index')->only('index');
        $this->middleware('permission:company_info.edit')->only('edit','update');
    }

    public function index()
    {
        $company = Company::first();
        return view('company.index',compact('company'));
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        $socials = json_decode($company->social, true);
        return  view('company.edit',compact('company','socials'));
    }

    public function update(Request $request,$id)
    {
        $this->validate($request,[
            'company_name' => 'required|Max:30',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required|Max: 100',
            'bin' => 'required',
            'facebook' => 'required',
            'twitter' => 'required',
            'linkedin' => 'required',
            'pinterest' => 'required',
            'image' => 'image',
            'favicon' => 'image',
            'og_image' => 'image',
            'tagline' => 'required|max:100',
        ]);

        $social_arr = ['facebook' => [$request->facebook,$request->visibility1], 'twitter' => [$request->twitter,$request->visibility2], 'pinterest' => [$request->pinterest,$request->visibility4],'linkedin' => [$request->linkedin,$request->visibility3]];

        $company = Company::findOrFail($id);

        if($request->hasFile('image')){
            //get form image
            $image = $request->file('image');
            $slug = Str::slug($company->company_name).'_logo_'.rand(1,100);
            $current_date = Carbon::now()->toDateString();
            //get unique name for image
            $image_name = $slug."_".$current_date.".".$image->getClientOriginalExtension();

            //Delete Old Image
            $old_cropped_location = public_path('uploads/logo/cropped/'.$company->image);
            $old_original_image_location = public_path('uploads/logo/original/'.$company->image);

            if (File::exists($old_cropped_location)) {
                File::delete($old_cropped_location);
            }
            if (File::exists($old_original_image_location)) {
                File::delete($old_original_image_location);
            }

            //location for new image
            $cropped_location = public_path('uploads/logo/cropped/'.$image_name);
            $original_image_location = public_path('uploads/logo/original/'.$image_name);
            //resize image for category and upload temp

            Image::make($image)->fit(183,66)->save($cropped_location);
            Image::make($image)->save($original_image_location);
            $company->logo =  $image_name;
         }

         if($request->hasFile('favicon')){
            //get form image
            $favicon = $request->file('favicon');
            $slug = Str::slug($company->company_name).'_favicon_'.rand(1,100);
            $current_date = Carbon::now()->toDateString();
            //get unique name for image
            $favicon_name = $slug."_".$current_date.".".$favicon->getClientOriginalExtension();

            //Delete Old Image
            $old_favicon_cropped_location = public_path('uploads/favicon/cropped/'.$company->favicon);
            $old_original_favicon_location = public_path('uploads/favicon/original/'.$company->favicon);

            if (File::exists($old_favicon_cropped_location)) {
                File::delete($old_favicon_cropped_location);
            }
            if (File::exists($old_original_favicon_location)) {
                File::delete($old_original_favicon_location);
            }

            //location for new image
            $cropped_location = public_path('uploads/favicon/cropped/'.$favicon_name);
            $original_favicon_location = public_path('uploads/favicon/original/'.$favicon_name);
            //resize image for category and upload temp

            Image::make($favicon)->fit(100,100)->save($cropped_location);
            Image::make($favicon)->save($original_favicon_location);
            $company->favicon =  $favicon_name;
         }

        if($request->hasFile('og_image')){
            //get form image
            $og_image = $request->file('og_image');
            $slug = Str::slug($company->company_name).'_og_image_'.rand(1,100);
            $current_date = Carbon::now()->toDateString();
            //get unique name for image
            $og_image_name = $slug."_".$current_date.".".$og_image->getClientOriginalExtension();

            //Delete Old Image
            $old_og_image_cropped_location = public_path('uploads/favicon/cropped/'.$company->og_image);
            $old_og_image_original_favicon_location = public_path('uploads/favicon/original/'.$company->og_image);

            if (File::exists($old_og_image_cropped_location)) {
                File::delete($old_og_image_cropped_location);
            }
            if (File::exists($old_og_image_original_favicon_location)) {
                File::delete($old_og_image_original_favicon_location);
            }

            //location for new image
            $cropped_location = public_path('uploads/favicon/cropped/'.$og_image_name);
            $original_og_image_location = public_path('uploads/favicon/original/'.$og_image_name);
            //resize image for category and upload temp

            Image::make($og_image)->fit(100,100)->save($cropped_location);
            Image::make($og_image)->save($original_og_image_location);
            $company->og_image =  $og_image_name;
        }



        $company->company_name = $request->company_name;
        $company->email = $request->email;
        $company->phone = $request->phone;
        $company->address = $request->address;
        $company->bin = $request->bin;
        $company->social = $social_arr;
        $company->map_embed = $request->map_embed;
        $company->tagline = $request->tagline;
        $company->short_description = $request->short_description;
        $company->save();
        Cache::forget('company_info');
        Toastr::success('Company Information Updated Successfully', 'success');
        return redirect()->route('company.index');
    }


    public function destroy(Company $company)
    {
        //
    }
}
