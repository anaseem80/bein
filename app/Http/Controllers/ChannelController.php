<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\ChannelImage;
use DataTables;
use Illuminate\Http\Request;
use Image;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'القنوات';
        //Sending GET Response to show items in datatables
        if ($request->ajax()) {
            $channels = Channel::latest()->get();
            return DataTables()->of($channels)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables
        return view('dashboard.channels.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "إضافة قنوات جديدة";
        $action = 'add';
        return view('dashboard.channels.add', compact('title', 'action'));
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
        unset($data['images']);
        //End remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model

        //Uploding Image
        $up_file = 'uploads/channels/';
        if ($request->hasFile('image')) {
            $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->resize(200, 200)->save($up_file . $img_name);
            $data['image'] = $up_file . $img_name;
        }
        //End uploding Image
        $channel = Channel::create($data);
        //Uploding multi Images
        if ($request->images) {
            foreach ($request->images as $image) {
                $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower(($image)->getClientOriginalExtension());
                Image::make($image)->resize(200, 200)->save($up_file . $img_name);
                //Save each image
                $channel->images()->save(new ChannelImage(['image' => $up_file . $img_name]));
                //End save each image
            }
        }
        //End uploding multi Images
        return redirect()->route('channel.index')->with('success', 'تم إضافة القنوات بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel)
    {
        $title = "تعديل القنوات";
        $action = 'update';
        //Sending GET Response to show items in datatables for images
        if (request()->ajax()) {
            return DataTables()->of($channel->images)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables for images
        return view('dashboard.channels.add', compact('title', 'action', 'channel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Channel $channel)
    {
        //Initiate new variable to take request items to be able to modify what we need
        $data = $request->all();
        //Remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model
        unset($data['images']);
        //End remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model

        //Uploding Image
        $up_file = 'uploads/channels/';
        if ($request->hasFile('image')) {
            $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->resize(200, 200)->save($up_file . $img_name);
            $data['image'] = $up_file . $img_name;
            if (file_exists($channel->image)) {
                unlink($channel->image);
            }
        }
        //End uploding Image

        //Uploding multi Images
        if ($request->images) {
            foreach ($request->images as $image) {
                $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower(($image)->getClientOriginalExtension());
                Image::make($image)->resize(200, 200)->save($up_file . $img_name);
                //Save each image
                $channel->images()->save(new ChannelImage(['image' => $up_file . $img_name]));
                //End save each image
            }
        }
        //End uploding multi Images
        $channel->update($data);
        return redirect()->route('channel.index')->with('success', 'تم تعديل القنوات بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Get the id of selected item to be removed
        $id = $request->id;
        //End get the id of selected item to be removed
        $channel = Channel::find($id);
        //Remove image file first
        if (file_exists($channel->image)) {
            unlink($channel->image);
        }
        $images = ChannelImage::where('channel_id', $id)->get();
        foreach ($images as $image) {
            if (file_exists($image->image)) {
                unlink($image->image);
            }
        }
        //End remove image file first
        $channel->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف القناة بنجاح',
        ]);
    }

    public function delete_image(Request $request)
    {
        //Get the id of selected image to be removed
        $id = $request->id;
        //End get the id of selected image to be removed
        $channel = Channel::find($id);
        //Remove image file first
        if (file_exists($channel->image)) {
            unlink($channel->image);
        }
        //End remove image file first
        $channel->image = null;
        $channel->save();

        return response()->json([
            'success' => true,
        ]);
    }

    public function delete_channel_images(Request $request)
    {
        //Get the id of selected image to be removed
        $id = $request->id;
        //End get the id of selected image to be removed
        $image = ChannelImage::find($id);
        //Remove image file first
        if (file_exists($image->image)) {
            unlink($image->image);
        }
        //End remove image file first
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الصورة بنجاح',

        ]);
    }
}
