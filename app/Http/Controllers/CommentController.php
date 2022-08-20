<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user=auth()->user();
        $data=$request->all();
        if($user){
            $data['created_by']=$user->id;
        }
        $comment= Comment::create($data);
        $comment=Comment::with('user')->find($comment->id);
        
        return response()->json([
            'success'=>true,
            'comment'=>$comment
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Get the id of selected image to be removed permenently
        $id = $request->id;
        //End get the id of selected image to be removed permenently
        Comment::onlyTrashed()->find($id)->forceDelete();
        return response()->json([
            'success' => true,
            'message' => 'تم حذف التعليق بنجاح',
        ]);
    }
    public function restore(Request $request)
    {
        //Get the id of selected image to be restored
        $id = $request->id;
        //End get the id of selected image to be restored
        Comment::withTrashed()->find($id)->restore();

        return response()->json([
            'success' => true,
        ]);
    }
    public function delete(Request $request)
    {
        //Get the id of selected image to be soft deleted
        $id = $request->id;
        //End get the id of selected image to be soft deleted
        $comment = Comment::find($id);
        $comment->deleted_by = auth()->user()->id;
        $comment->save();
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف التعليق بنجاح',
        ]);
    }
    public function deletedComments(Request $request, $type)
    {
        switch ($type) {
            case 'blogs':
                $title = 'التعليقات المحذوفة من المقالات';
                break;
            case 'packages':
                $title = 'التعليقات المحذوفة من الباقات';
                break;
        }
        //Sending GET Response to show items in datatables
        if ($request->ajax()) {
            $comments = Comment::where('type', $type)->with('userDeletes', 'user', $type)->onlyTrashed()->get();
            return DataTables()->of($comments)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables

        return view('dashboard.comments', compact('title', 'type'));
    }
    public static function deletedExist()
    {
        //Static function to be used in the view to show if there are deleted comments
        return count(Comment::onlyTrashed()->get()) > 0;
    }
}
