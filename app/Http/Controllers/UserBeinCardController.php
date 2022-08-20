<?php

namespace App\Http\Controllers;

use App\Models\UserBeinCard;
use DataTables;
use Illuminate\Http\Request;

class UserBeinCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'Bein Card Number';
        //Sending GET Response to show items in datatables
        if ($request->ajax()) {
            $numbers = UserBeinCard::where('user_id', auth()->user()->id)->latest()->get();
            return DataTables()->of($numbers)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables
        return view('dashboard.profile.beinCard', compact('title'));
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
        $user = auth()->user();
        $number = $request->number;
        $exist = UserBeinCard::where('user_id', $user->id)->where('bein_card_number', $number)->first();
        if ($exist) {
            return response()->json([
                'success' => false,
                'message' => 'الرقم مسجل من قبل',
            ]);
        } else {
            $card = new UserBeinCard();
            $card->user_id = $user->id;
            $card->bein_card_number = $number;
            $card->save();
            return response()->json([
                'success' => true,
                'message' => 'تم الحفظ بنجاح',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserBeinCard  $userBeinCard
     * @return \Illuminate\Http\Response
     */
    public function show(UserBeinCard $userBeinCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserBeinCard  $userBeinCard
     * @return \Illuminate\Http\Response
     */
    public function edit(UserBeinCard $userBeinCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserBeinCard  $userBeinCard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $number = $request->number;
        $id = $request->id;
        $exist = UserBeinCard::where('user_id', $user->id)->where('bein_card_number', $number)->where('id', '<>', $id)->first();
        if ($exist) {
            return response()->json([
                'success' => false,
                'message' => 'الرقم مسجل من قبل',
            ]);
        } else {
            $card = UserBeinCard::find($id);
            if ($user->id != $card->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'ليس لديك صلاحية لتعديل هذا العنصر',
                ]);
            } else {
                if ($number == $card->bein_card_number) {
                    return response()->json([
                        'success' => false,
                        'message' => 'لم تقم بتغيير الرقم',
                    ]);
                } else {
                    $card->bein_card_number = $number;
                    $card->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'تم الحفظ بنجاح',
                    ]);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserBeinCard  $userBeinCard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $currentUser = auth()->user();
        $id = $request->id;
        $card = UserBeinCard::find($id);
        if ($currentUser->id != $card->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية لحذف هذا العنصر',
            ]);
        } else {
            $card->delete();
            return response()->json([
                'success' => true,
                'message' => 'تم حذف الرقم بنجاح',
            ]);
        }
    }
}
