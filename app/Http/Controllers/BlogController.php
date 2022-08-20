<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogsResource;
use App\Models\Blog;
use App\Models\Category;
use App\Models\CategoryBlog;
use App\Models\Comment;
use DataTables;
use Illuminate\Http\Request;
use Image;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = 'المقالات';
        //Sending GET Response to show items in datatables
        if ($request->ajax()) {
            $blogs = BlogsResource::collection(Blog::all()->sortByDesc('id'));
            return DataTables()->of($blogs)->addIndexColumn()->make(true);
        }
        //End sending GET Response to show items in datatables
        return view('dashboard.blogs.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "إضافة مقال جديد";
        $action = 'add';
        //Get Categories to be linked to the new Blog
        $categories = Category::all();
        //End get categories to be linked to the new Blog
        return view('dashboard.blogs.add', compact('title', 'action', 'categories'));
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
        unset($data['categories']);
        unset($data['preview']);
        //End remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model
        //Uploding Image
        $up_file = 'uploads/blogs/';
        if ($request->hasFile('image')) {
            $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->save($up_file . $img_name);
            $data['image'] = $up_file . $img_name;
        }
        //End uploding Image
        $blog = Blog::create($data);
        foreach ($request->categories as $category) {
            //Linking categories to Blog
            $blog->categories()->attach($category);
            //End linking categories to Blog
        }

        if ($request->preview) {
            return redirect()->route('blog.show', $blog)->with('success', 'تم إضافة المقال بنجاح');
        }

        return redirect()->route('blog.index')->with('success', 'تم إضافة المقال بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        $title = "معاينة المقال";
        $preview=true;
        return view('front.article', compact('title','preview'))->with('article',$blog);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $title = "تعديل المقال";
        $action = 'update';
        //Get Categories to be linked to the Blog
        $categories = Category::all();
        //End get categories to be linked to the Blog
        return view('dashboard.blogs.add', compact('title', 'action', 'categories', 'blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //Initiate new variable to take request items to be able to modify what we need
        $data = $request->all();
        //Remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model
        unset($data['categories']);
        unset($data['preview']);
        //End remove items from request to prevent errors from creating model because they are not found in the columns of the table represented by this model
        //Uploding Image
        if ($request->hasFile('image')) {
            $up_file = 'uploads/blogs/';
            $img_name = $data['name'] . hexdec(uniqid()) . '.' . strtolower($request->file('image')->getClientOriginalExtension());
            Image::make($request->file('image'))->save($up_file . $img_name);
            $data['image'] = $up_file . $img_name;
            if (file_exists($blog->image)) {
                unlink($blog->image);
            }
        }
        //End uploding Image
        $blog->update($data);
        //Empty all Categories linked to blog to update it
        CategoryBlog::where('blog_id', $blog->id)->delete();
        foreach ($request->categories as $category) {
            //Linking categories to Blog
            $blog->categories()->attach($category);
            //End linking categories to Blog
        }

        if ($request->preview) {
            return redirect()->route('blog.show', $blog)->with('success', 'تم تعديل المقال بنجاح');
        }

        return redirect()->route('blog.index')->with('success', 'تم تعديل المقال بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Get the id of selected item to be removed
        $id = $request->id;
        $blog = Blog::find($id);
        //End get the id of selected item to be removed
        Comment::where('item_id', $id)->where('type', 'blogs')->delete();
        //Remove image file first
        if (file_exists($blog->image)) {
            unlink($blog->image);
        }
        $blog->delete();
        return response()->json([
            'success' => true,
            'message' => 'تم حذف المقال بنجاح',
        ]);
    }
    public function change_published(Request $request)
    {
        //Get the id of selected item to change its status
        $id = $request->id;
        //End get the id of selected item to change its status

        $status = $request->status;
        Blog::find($id)->update([
            'is_published' => $status,
        ]);

        return response()->json([
            'success' => true,
            'message' => $status == 0 ? 'تم إلغاء نشر المقال' : 'تم نشر المقال',
        ]);
    }
    public function delete_image(Request $request)
    {
        //Get the id of selected image to be removed
        $id = $request->id;
        //End get the id of selected image to be removed
        $blog = Blog::find($id);
        //Remove image file first
        if (file_exists($blog->image)) {
            unlink($blog->image);
        }
        //End remove image file first
        $blog->image = null;
        $blog->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
