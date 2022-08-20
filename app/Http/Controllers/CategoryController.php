<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriesResource;
use App\Models\Category;
use DataTables;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'الفئات';
        //Sending GET Response to show items in datatables
        if ($request->ajax()) {
            $categories = CategoriesResource::collection(Category::all()->sortByDesc('id'));
            return DataTables()->of($categories)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables
        return view('dashboard.categories.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "إضافة فئة جديدة";
        $action = 'add';
        return view('dashboard.categories.add', compact('title', 'action'));
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
        unset($data['type']);
        //End remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model
        $category = Category::create($data);
        if ($request->type == 'json') {
            return response()->json([
                'success' => true,
                'category' => $category,
            ]);
        } else {
            return redirect()->route('category.index')->with('success', 'تم إضافة الفئة بنجاح');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $title = "تعديل الفئة";
        $action = 'update';
        return view('dashboard.categories.add', compact('title', 'action', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //Initiate new variable to take request items to be able to modify what we need
        $data = $request->all();
        $category->update($data);
        return redirect()->route('category.index')->with('success', 'تم تعديل الفئة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Get the id of selected item to be removed
        $id = $request->id;
        //End get the id of selected item to be removed
        $category = Category::find($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الفئة بنجاح',
        ]);
    }
}
