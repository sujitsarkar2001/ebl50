<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.video.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|string|max:255',
            'link'      => 'required|url|max:255',
            'thumbnail' => 'required|image|max:1024|mimes:jpeg,jpg,png'
        ]);
        $thumbnail = $request->file('thumbnail');
        $currentDate = Carbon::now()->toDateString();
        $thumbnailName = $currentDate.'-'.uniqid().'.'.$thumbnail->getClientOriginalExtension();

        if (!file_exists('uploads/video')) {
            mkdir('uploads/video', 0777, true);
        }
        $thumbnail->move(public_path('uploads/video'), $thumbnailName);

        Video::create([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title),
            'thumbnail' => $thumbnailName,
            'link'      => $request->link,
            'rate'      => setting('daily_income_bonus'),
            'date'      => date('Y-m-d'),
            'month'     => date('F'),
            'year'      => date('Y')
        ]);
        
        return response()->json([
            'alert'   => 'Success',
            'message' => 'Video successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Video $video
     * @return Response
     */
    public function show(Video $video)
    {
        return response()->json($video);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Video $video
     * @return Response
     */
    public function edit(Video $video)
    {
        $status = $video->status ? false:true;
        $video->status = $status;
        $video->save();

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Video status successfully updated'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Video $video
     * @return Response
     */
    public function update(Request $request, Video $video)
    {
        $this->validate($request, [
            'title'     => 'required|string|max:255',
            'link'      => 'required|url|max:255',
            'thumbnail' => 'nullable|image|max:1024|mimes:jpeg,jpg,png'
        ]);

        $thumbnail = $request->file('thumbnail');

        if ($thumbnail) {

            $currentDate   = Carbon::now()->toDateString();
            $thumbnailName = $currentDate.'-'.uniqid().'.'.$thumbnail->getClientOriginalExtension();

            if (!file_exists('uploads/video')) {
                mkdir('uploads/video', 0777, true);
            }

            if (!file_exists('uploads/video')) {
                unlink('uploads/video/'.$video->thumbnail);
            }

            $thumbnail->move(public_path('uploads/video'), $thumbnailName);
        }


        $video->update([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title),
            'thumbnail' => $thumbnailName ?? $video->thumbnail,
            'link'      => $request->link,
            'rate'      => $request->rate
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Video successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Video $video
     * @return Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return response()->json([
            'alert'   => 'Success',
            'message' => 'Video successfully deleted'
        ]);
    }
}
