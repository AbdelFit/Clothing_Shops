<?php

namespace App\Http\Controllers;

use App\Blog;
use File;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'blogs' => $blogs
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'title' => 'required',
            'feature_image' => 'required|image',
        ]);

        if (!$request->hasFile('feature_image')) {
            return abort(404, 'Image not uploaded!');
        }

        $filename = $request->feature_image->getClientOriginalName();
        $request->feature_image->move('storage/images_feature_image/', $filename);

        $blog = new Blog($request->except('feature_image'));
        $blog->feature_image = $filename;
        $blog->save();

        return response()
            ->json([
                'saved' => true,
                'message' => 'You have successfully created your blog!'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        return response()
            ->json([
                'blog' => $blog
            ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'content' => 'required',
            'title' => 'required',
        ]);

        $blog = Blog::findOrFail($id);

        // upload image
        if ($request->hasfile('feature_image') && $request->file('feature_image')->isValid()) {
            $filename = $request->feature_image->getClientOriginalName();
            $request->feature_image->move('storage/images_feature_image/', $filename);

        // remove old image
            File::delete('storage/images_feature_image/' . $blog->feature_image);
            $blog->feature_image = $filename;
        }

        $blog->content = $request->content;
        $blog->title = $request->title;
        $blog->save();

        return response()
            ->json([
                'saved' => true,
                'message' => 'You have successfully updated your blog!'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        File::delete('storage/images_feature_image/' . $blog->image);

        $blog->delete();

        return response()
            ->json([
                'deleted' => true
            ]);
    }


    /**
     * Upload blog images
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function blog_image(Request $request)
    {
        if (!$request->hasFile('image') && !$request->file('image')->isValid()) {
            return abort(404, 'Image not uploaded!');
        }

        $filename = $request->image->getClientOriginalName();
        $request->image->move('storage/images_blog/', $filename);

        return response()->json([
            'url' => '/storage/images_blog/' . $filename
        ]);
    }
}
