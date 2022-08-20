<?php

namespace App\Http\Controllers;

use Image;
use DataTables;
use App\Models\Device;
use App\Models\Channel;
use App\Models\Comment;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\PackageDevice;
use App\Models\PackageChannel;
use App\Models\PackageChannelImage;
use App\Http\Resources\PackagesResource;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offers=$request->offers;
        //Check if request from main package or sub package
        $is_sub = $request->subpackages;
        //End check if request from main package or sub package
        $title = "الباقات";
        //Sending GET Response to show items in datatables
        if ($request->ajax()) {
            //Get packages according to if it is main or sub
            if(isset($offers)){
                $packages = PackagesResource::collection(Package::all()->where('is_offer',1)->sortByDesc('id'));
            }else{
                $packages = PackagesResource::collection(Package::all()->sortByDesc('id'));
            }
            //End get packages according to if it is main or sub
            return DataTables()->of($packages)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables
        return view('dashboard.packages.index', compact('title','offers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Check if request from main package or sub package
        // $is_sub = request('subpackages');
        //End check if request from main package or sub package
        // if ($is_sub) {
        //     $title = "إضافة باقة فرعية جديدة";
        // } else {
        $title = "إضافة باقة جديدة";
        // }
        $action = 'add';
        //Get all devices and channels to link selected ones to package and main packages if sub package created
        $devices = Device::all();
        $channels = Channel::all();
        // $mainPackages = Package::whereNull('parent_id')->get();
        //End get all devices and channels to link selected ones to package and main packages if sub package created
        return view('dashboard.packages.add', compact('title', 'action', 'devices', 'channels'));
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
        //Remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model
        unset($data['channels']);
        unset($data['devices']);
        // unset($data['subpackages']);
        unset($data['images']);
        $data['is_offer']=$request->has('is_offer');
        //End remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model
        
        //Uploding Image
        $up_file = 'uploads/packages/';
        if ($request->hasFile('image')) {
            $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->resize(200, 200)->save($up_file . $img_name);
            $data['image'] = $up_file . $img_name;
        }
        
        if ($request->hasFile('cover')) {
            $cover_name ='cover-'. $data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('cover')->getClientOriginalExtension());
            Image::make($request->file('cover'))->resize(1366, 300)->save($up_file . $cover_name);
            $data['cover'] = $up_file . $cover_name;
        }
        //End uploding Image
        $package = Package::create($data);
        
        //Link with channels and channelImages
        if ($request->channels) {
            if (count($request->channels) > 0) {
                foreach ($request->channels as $channel) {
                    $package->channels()->attach($channel);
                }
            }
        }
        if ($request->devices) {
            if (count($request->devices) > 0) {
                foreach ($request->devices as $device) {
                    $package->devices()->attach($device);
                }
            }
        }
        if ($request->images) {
            if (count($request->images) > 0) {
                foreach ($request->images as $img) {
                    $package->channelImages()->attach($img);
                }
            }
        }
        //End link with channels and channelImages
        // $is_sub = $request->subpackages;

        //Redirect according to package type
        // if ($is_sub) {
        //     return redirect(route('package.index') . '?subpackages=true')->with('success', 'تم إضافة الباقة بنجاح');
        // } else {

        //     if (isset($data['parent_id'])) {
        //         return redirect()->route('package.edit', $data['parent_id'])->with('success', 'تم إضافة الباقة بنجاح');
        //     } else {
        return redirect()->route('package.index')->with('success', 'تم إضافة الباقة بنجاح');
        // }
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        //Check if request from main package or sub package
        // $is_sub = request('subpackages');
        //End check if request from main package or sub package
        // if ($is_sub) {
        //     $title = "تعديل باقة فرعية ";
        //     if ($package->parent_id == null) {
        //         return redirect()->route('package.edit', $package);
        //     }
        // } else {
        $title = "تعديل باقة ";
        //     if ($package->parent_id != null) {
        //         return redirect(route('package.edit', $package) . '?subpackages=true');
        //     }
        // }

        $action = 'update';
        //Get all devices and channels to link selected ones to package and main packages if sub package updated
        $devices = Device::all();
        $channels = Channel::all();
        // $mainPackages = Package::whereNull('parent_id')->get();
        //End get all devices and channels to link selected ones to package and main packages if sub package updated
        return view('dashboard.packages.add', compact('title', 'action', 'package', 'devices', 'channels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        //Initiate new variable to take request items to be able to modify what we need
        $data = $request->all();
        //Remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model
        unset($data['channels']);
        unset($data['devices']);
        // unset($data['subpackages']);
        unset($data['images']);
        unset($data['remove_cover']);
        $data['is_offer']=$request->has('is_offer');
        //End remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model

        //Uploding Image
        $up_file = 'uploads/packages/';
        if ($request->hasFile('image')) {
            $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->resize(200, 200)->save($up_file . $img_name);
            $data['image'] = $up_file . $img_name;
            if (file_exists($package->image)) {
                unlink($package->image);
            }
        }
        if(!$request->has('remove_cover')){
            if ($request->hasFile('cover')) {
                $cover_name = 'cover-'.$data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('cover')->getClientOriginalExtension());
                Image::make($request->file('cover'))->resize(1366, 300)->save($up_file . $cover_name);
                $data['cover'] = $up_file . $cover_name;
                if (file_exists($package->cover)) {
                    unlink($package->cover);
                }
            }
        }else{
            $data['cover']=null;
            if (file_exists($package->cover)) {
                unlink($package->cover);
            } 
        }
        //End uploding Image
        $package->update($data);
        //Link with channels and channelImages
        //Empty all channels linked to package to update it
        PackageChannel::where('package_id', $package->id)->delete();
        if ($request->channels) {
            if (count($request->channels) > 0) {
                foreach ($request->channels as $channel) {
                    $package->channels()->attach($channel);
                }
            }
        }
        PackageDevice::where('package_id', $package->id)->delete();
        if ($request->devices) {
            if (count($request->devices) > 0) {
                foreach ($request->devices as $device) {
                    $package->devices()->attach($device);
                }
            }
        }
        //Empty all channelImages linked to package to update it
        PackageChannelImage::where('package_id', $package->id)->delete();
        if ($request->images) {
            if (count($request->images) > 0) {
                foreach ($request->images as $img) {
                    $package->channelImages()->attach($img);
                }
            }
        }
        //End link with channels and channelImages
        // $is_sub = $request->subpackages;

        //Redirect according to package type
        // if ($is_sub) {
        //     return redirect(route('package.index') . '?subpackages=true')->with('success', 'تم تعديل الباقة بنجاح');
        // } else {

        //     if (isset($data['parent_id'])) {
        //         return redirect()->route('package.edit', $data['parent_id'])->with('success', 'تم تعديل الباقة بنجاح');
        //     } else {
        return redirect()->route('package.index')->with('success', 'تم تعديل الباقة بنجاح');
        //     }
        // }
        //package->subPackages()->save($subpackage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Get the id of selected item to be removed
        $id = $request->id;
        //End get the id of selected item to be removed
        Comment::where('item_id', $id)->where('type', 'packages')->delete();
        $package = Package::find($id);
        //Remove image file first
        if (file_exists($package->image)) {
            unlink($package->image);
        }
        Setting::where('type','packages')->where('key',$id)->delete();
        Setting::where('type','worldCup')->where('value',$id)->delete();
        //End remove image file first
        $package->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الباقة بنجاح',
        ]);
    }
    public function delete_image(Request $request)
    {
        //Get the id of selected image to be removed
        $id = $request->id;
        //End get the id of selected image to be removed
        $package = Package::find($id);
        //Remove image file first
        if (file_exists($package->image)) {
            unlink($package->image);
        }
        //End remove image file first
        $package->image = null;
        $package->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
