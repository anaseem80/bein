<?php

namespace App\Http\Controllers;

use Image;
use DataTables;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    static $info = ['telephone', 'email', 'currency', 'pay_currency', 'shipping_duration', 'sidebar_color'];
    static $paragraphs = ['mainPackages'];
    static $worldCup = ['worldCup'];
    static $social = ['facebook', 'twitter', 'youtube', 'google', 'instagram', 'tiktok'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "إعدادات الموقع";
        //site information
        $logo = Setting::where('key', 'logo')->first();
        if (!$logo) {
            $logo = new Setting();
            $logo->key = 'logo';
            $logo->save();
        }
        $packages_cover = Setting::where('key', 'packages_cover')->first();
        if (!$packages_cover) {
            $packages_cover = new Setting();
            $packages_cover->key = 'packages_cover';
            $packages_cover->save();
        }
        $info = [];
        $info['logo'] = $logo;
        $info['packages_cover'] = $packages_cover;
        foreach (SettingController::$info as $i) {
            $item = Setting::where('key', $i)->first();
            if (!$item) {
                $item = new Setting();
                $item->type = 'info';
                $item->key = $i;
                if ($i == 'currency' || $i == 'pay_currency') {
                    $item->value = "$";
                }
                if ($i == 'sidebar_color') {
                    $item->value = "#4e73df";
                }
                $item->save();
            }
            $info[$i] = $item;
        }
        //end site information

        //social links
        $social = [];
        foreach (SettingController::$social as $i) {
            $item = Setting::where('key', $i)->first();
            if (!$item) {
                $item = new Setting();
                $item->type = 'social';
                $item->key = $i;
                $item->save();
            }
            $social[$i] = $item;
        }
        //end social links
        $packages = Package::get();
        $paragraphs = [];
        foreach (SettingController::$paragraphs as $i) {
            $item = Setting::where('key', $i)->first();
            if (!$item) {
                $item = new Setting();
                $item->type = 'paragraphs';
                $item->key = $i;
                $item->save();
            }
            $paragraphs[$i] = $item;
        }
        $worldCup = [];
        foreach (SettingController::$worldCup as $i) {
            $item = Setting::where('key', $i)->first();
            if (!$item) {
                $item = new Setting();
                $item->type = 'worldCup';
                $item->key = $i;
                $item->save();
            }
            $worldCup[$i] = $item;
        }
        $mainPackages=Setting::where('type','packages')->get();
        foreach($mainPackages as $p ){
            if(!Package::find($p->key)){
                Setting::find($p->id)->delete();
            }
        }
        $worldCupPackage=Setting::where('key','worldCup')->first();
        if($worldCupPackage->value!=null){
            if(!Package::find($worldCupPackage->value)){
                Setting::find($worldCupPackage->id)->delete();
            }
        }
        return view('dashboard.settings.index', compact('title', 'info', 'social', 'packages', 'paragraphs', 'worldCup'));
    }
    public function slidersList(Request $request)
    {
        //Sending GET Response to show items in datatables
        $sliders = Setting::where('type', 'sliders')->latest()->get();
        return DataTables()->of($sliders)->addIndexColumn()->make(true);
        //End sending GET Response to show items in datatables
    }
    public function mainPackages(Request $request)
    {
        //Sending GET Response to show items in datatables
        $packages = Setting::leftJoin('packages', 'packages.id', 'key')->where('settings.type', 'packages')->latest()->get(['settings.*', 'packages.name', 'packages.description', 'packages.price_90', 'packages.price_180', 'packages.price_365', 'packages.image']);
        return DataTables()->of($packages)->addIndexColumn()->make(true);
        //End sending GET Response to show items in datatables
    }
    public function taxes(Request $request)
    {
        //Sending GET Response to show items in datatables
        $taxes = Setting::where('type', 'taxes')->orderBy('key','asc')->get();
        return DataTables()->of($taxes)->addIndexColumn()->make(true);
        //End sending GET Response to show items in datatables
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Get setting type from request
        $type = $request->type;
        //End get setting type from request
        $data = [];
        $message = '';
        switch ($type) {
            case 'info':
                //Upload logo
                $up_file = 'uploads/settings/';
                if ($request->hasFile('logo')) {
                    $logo = Setting::where('key', 'logo')->first();
                    $img_name = 'logo' . hexdec(uniqid()) . '.' . strtolower($request->file('logo')->getClientOriginalExtension());
                    Image::make($request->file('logo'))->save($up_file . $img_name);
                    if ($logo->value) {
                        if (file_exists($logo->value)) {
                            unlink($logo->value);
                        }
                    }
                    $logo->value = $up_file . $img_name;
                    $logo->save();
                }
                $cover = Setting::where('key', 'packages_cover')->first();
                if (!$request->has('remove_cover')) {
                    if ($request->hasFile('packages_cover')) {
                        $cover_name = 'packages_cover-' . hexdec(uniqid()) . '.' . strtolower($request->file('packages_cover')->getClientOriginalExtension());
                        Image::make($request->file('packages_cover'))->resize(1366, 300)->save($up_file . $cover_name);
                        if ($cover->value) {
                            if (file_exists($cover->value)) {
                                unlink($cover->value);
                            }
                        }
                        $cover->value = $up_file . $cover_name;
                        $cover->save();
                    }
                } else {
                    if (file_exists($cover->value)) {
                        unlink($cover->value);
                    }
                    $cover->value=null;
                    $cover->save();
                }
                //End upload logo
                $data = SettingController::$info;
                $message = 'تم تعديل معلومات الموقع بنجاح';
                break;
            case 'social':
                $data = SettingController::$social;
                $message = 'تم تعديل وسائل التواصل بنجاح';
                break;
            case 'paragraphs':
                $data = SettingController::$paragraphs;
                $message = 'تم تعديل الفقرة بنجاح';
                break;
            case 'worldCup':
                $data = SettingController::$worldCup;
                $message = 'تم تعديل باقة كأس العالم بنجاح';
                break;
        }
        Setting::where('type', $type)->delete();
        foreach ($data as $i) {
            $item = new Setting();
            $item->type = $type;
            $item->key = $i;
            $item->value = request($i);
            if (request("status")) {
                if (request($i)) {
                    $item->status = 1;
                }
            }
            $item->save();
        }
        return redirect()->back()->with('success', $message);
    }
    public function storeSlider(Request $request)
    {
        $message = "";
        $id = $request->id;
        if ($id > 0) {
            $slider = Setting::find($id);
            $message = "تم تعديل الغلاف بنجاح";
        } else {
            $slider = new Setting();
            $slider->type = 'sliders';
            $message = "تم إضافة الغلاف بنجاح";
        }

        if ($request->hasFile('image')) {
            $up_file = 'uploads/settings/';
            $img_name = 'slider' . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->resize(768, 432)->save($up_file . $img_name);
            if ($id > 0) {
                if (file_exists($slider->key)) {
                    unlink($slider->key);
                }
            }
            $slider->key = $up_file . $img_name;
        }
        $slider->value = $request->title;
        $slider->description = str_replace(["https://", "http://"], "", $request->url);
        $slider->description_2 = str_replace(["https://", "http://"], "", $request->url2);
        $slider->save();

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
    public function storeMainPackage(Request $request)
    {
        $packageId = $request->packageId;
        $exist = Setting::where('type', 'packages')->where('key', $packageId)->first();
        if ($exist) {
            return response()->json([
                'success' => false,
                'message' => 'الباقة تم إضافتها بالفعل',
            ]);
        } else {
            $packageSetting = new Setting();
            $packageSetting->type = 'packages';
            $packageSetting->key = $packageId;
            $packageSetting->save();
            return response()->json([
                'success' => true,
                'message' => 'تمت الإضافة بنجاح',
            ]);
        }
    }
    public function storeTax(Request $request)
    {
        $message = "";
        $id = $request->id;
        if ($id > 0) {
            $tax = Setting::find($id);
            $message = "تم التعديل بنجاح";
        } else {
            $tax = new Setting();
            $tax->type = 'taxes';
            $message = "تمت الإضافة بنجاح";
        }
        $tax->key = $request->title;
        $tax->value = $request->value;
        $tax->description = $request->type;
        $tax->description_2 = $request->shown??0;
        $tax->status = $request->published??0;

        $tax->save();

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
    public function changeSettingStatus(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        Setting::find($id)->update([
            'status' => $status,
        ]);

        return response()->json([
            'success' => true,
            'status' => $status,
        ]);
    }
    public function changeTax(Request $request)
    {
        $id = $request->id;
        $column = $request->column;
        $value = $request->value;

        Setting::find($id)->update([
            $column => $value,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $setting = Setting::find($id);
        if (file_exists($setting->key)) {
            unlink($setting->key);
        }
        if (file_exists($setting->value)) {
            unlink($setting->value);
        }
        if (file_exists($setting->description)) {
            unlink($setting->description);
        }
        $setting->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم الحذف بنجاح'
        ]);
    }
    public function delete_image(Request $request)
    {
        $id = $request->id;
        $setting = Setting::find($id);
        if (file_exists($setting->value)) {
            unlink($setting->value);
        }
        $setting->value = null;
        $setting->save();

        return response()->json([
            'success' => true,
        ]);
    }
    public static function getSettingObj($key)
    {
        return Setting::where('key', $key)->first();
    }
    public static function getSettingValue($key)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : null;
    }
}
