<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->get();
        
        if (is_null($posts->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No post found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Posts are retrieved successfully.',
            'data' => $products,
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required|string|max:250',
            'body' => 'required|string|'
        ]);

        if($validate->fails()){  
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);    
        }

        $post = Post::create($request->all());

        $response = [
            'status' => 'success',
            'message' => 'Post is added successfully.',
            'data' => $post,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
  
        if (is_null($post)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Post is not found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Post is retrieved successfully.',
            'data' => $post,
        ];
        
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required'
        ]);

        if($validate->fails()){  
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }

        $post = Post::find($id);

        if (is_null($post)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Product is not found!',
            ], 200);
        }

        $post->update($request->all());
        
        $response = [
            'status' => 'success',
            'message' => 'Post is updated successfully.',
            'data' => $post,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::find($id);
  
        if (is_null($post)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Post is not found!',
            ], 200);
        }

        Post::destroy($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Post is deleted successfully.'
            ], 200);
    }

    /**
     * Search by a post title
     *
     * @param  str  $title
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $post = Post::where('title', 'like', '%'.$title.'%')
            ->latest()->get();

        if (is_null($post->first())) {
            return response()->json([
                'status' => 'failed',
                'message' => 'No post found!',
            ], 200);
        }

        $response = [
            'status' => 'success',
            'message' => 'Post are retrieved successfully.',
            'data' => $post,
        ];

        return response()->json($response, 200);
    }
}
