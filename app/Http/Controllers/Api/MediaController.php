<?php

namespace App\Http\Controllers\Api;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Image;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = 'image';
        $data = Media::where('user_id', Auth::user()->id)->where('type', 'LIKE', '%' . $type . '%')->get();

        return response([
            "data" => $data,
            "status" => 'ok',
            "success" => true,
            "message" => "success",
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,jpg,gif, | max:4086',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $env_url = config('app.url');

        //get real file name
        $originalFileName = $request->file->getClientOriginalName();

        // file size
        $originalFileSize = $request->file->getSize();

        //check again if file is present and upload to public/file
        if ($request->hasfile('file')) {
            $path = $request->file('file')->store('uploads', 'public');
        }

        //save file data
        $data = Media::create([
            'type' => $request->file->getMimeType(),
            'file_name' => $originalFileName,
            'file_size' => $originalFileSize,
            'user_id' => Auth::user()->id,
            'path' => $env_url . '/storage/' . $path
        ]);
        return response([
            "status" => "ok",
            "success" => true,
            "message" => "Image uploaded successfully",
            "data" => $data,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Media $media)
    {
        //
    }
}
