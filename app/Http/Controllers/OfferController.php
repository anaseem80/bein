<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Offer;
use App\Models\Package;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $offers = Offer::with('package')->latest()->get();
            return DataTables()->of($offers)->addIndexColumn()->make(true);
        }
        $title = "العروض";
        
        return view('dashboard.offers.index', compact('title'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title="إضافة عرض";
        $packages = Package::get();
        $action="add";

        return view('dashboard.offers.add', compact('title', 'packages','action'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $data['package_id'] = $request->package_id;
        $data['price'] = $request->price;
        $data['duration'] = $request->duration;
        $data['from'] = date('Y-m-d',strtotime($request->from));
        $data['to'] = date('Y-m-d',strtotime($request->to));
        $data['status'] = 0;
        $now = date('Y-m-d');

        if ($now >= $data['from'] && $now <= $data['to']) {
            $data['status'] = 1;
        } elseif ($now > $data['to']) {
            $data['status'] = 2;
        }
        $offer = Offer::create($data);

        return redirect()->route('offers.index')->with('success','تم إضافة العرض');
        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم إضافة العرض',
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        $title="تعديل عرض";
        $packages = Package::get();
        $action="add";

        return view('dashboard.offers.add', compact('title', 'packages','action','offer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Offer $offer)
    {
        $data = [];
        $data['price'] = $request->price;
        $data['duration'] = $request->duration;
        $data['from'] = date('Y-m-d',strtotime($request->from));
        $data['to'] = date('Y-m-d',strtotime($request->to));
        $data['status'] = 0;
        $now = date('Y-m-d');

        if ($now >= $data['from'] && $now <= $data['to']) {
            $data['status'] = 1;
        } elseif ($now > $data['to']) {
            $data['status'] = 2;
        }
        $offer->update($data);
        return redirect()->route('offers.index')->with('success','تم تعديل العرض');

        return response()->json([
            'success' => true,
            'message' => 'تم تعديل العرض',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Get the id of selected item to be removed
        $id = $request->id;
        //End get the id of selected item to be removed
        $offer = Offer::find($id);
        //End remove image file first
        $offer->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف العرض بنجاح',
        ]);
    }
}
