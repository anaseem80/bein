<?php

namespace App\Http\Controllers;

use Image;
use DataTables;
use App\Models\Device;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\DeviceCountry;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'الأجهزة';
        //Sending GET Response to show items in datatables
        if ($request->ajax()) {
            $devices = Device::latest()->get();
            return DataTables()->of($devices)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables
        return view('dashboard.devices.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "إضافة جهاز جديد";
        $action = 'add';
        $countries = Country::get();
        return view('dashboard.devices.add', compact('title', 'action', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Initiate new variable to take request items to be able to modify what we need
        $data = $request->all();
        $data['created_by'] = auth()->user()->id;
        $countries = Country::get();
        foreach ($countries as $country) {
            unset($data["country_" . $country->id]);
        }
        //Uploding Image
        if ($request->hasFile('image')) {
            $up_file = 'uploads/devices/';
            $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->resize(200, 200)->save($up_file . $img_name);
            $data['image'] = $up_file . $img_name;
        }
        //End uploding Image
        $device = Device::create($data);
        
        foreach ($countries as $country) {
            $cdata = ['device_id' => $device->id, 'country_id' => $country->id, 'shipping_price' => request("country_" . $country->id)];
            DeviceCountry::create($cdata);
        }

        return redirect()->route('device.index')->with('success', 'تم إضافة الجهاز بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        $title = "تعديل الجهاز";
        $action = 'update';
        $countries = Country::get();
        return view('dashboard.devices.add', compact('title', 'action', 'device', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        //Initiate new variable to take request items to be able to modify what we need
        $data = $request->all();
        $countries = Country::get();
        foreach ($countries as $country) {
            unset($data["country_" . $country->id]);
        }
        //Uploding Image
        if ($request->hasFile('image')) {
            $up_file = 'uploads/devices/';
            $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->resize(200, 200)->save($up_file . $img_name);
            $data['image'] = $up_file . $img_name;
            if (file_exists($device->image)) {
                unlink($device->image);
            }
        }
        //End uploding Image
        $device->update($data);
        DeviceCountry::where('device_id',$device->id)->delete();
        
        foreach ($countries as $country) {
            $cdata = ['device_id' => $device->id, 'country_id' => $country->id, 'shipping_price' => request("country_" . $country->id)];
            DeviceCountry::create($cdata);
        }
        return redirect()->route('device.index')->with('success', 'تم تعديل الجهاز بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Get the id of selected item to be removed
        $id = $request->id;
        //End get the id of selected item to be removed
        $device = Device::find($id);
        //Remove image file first
        if (file_exists($device->image)) {
            unlink($device->image);
        }
        //End remove image file first
        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الجهاز بنجاح',
        ]);
    }

    public function delete_image(Request $request)
    {
        //Get the id of selected image to be removed
        $id = $request->id;
        //End get the id of selected image to be removed
        $device = Device::find($id);
        //Remove image file first
        if (file_exists($device->image)) {
            unlink($device->image);
        }
        //End remove image file first
        $device->image = null;
        $device->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
