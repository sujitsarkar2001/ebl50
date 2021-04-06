<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::latest('id')->get();
        return view('admin.video.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.video.form');
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

        notify()->success("Video successfully added", "Success");
        return redirect()->route('admin.video.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        if ($video->status) {
            $video->update([
                'status' => false
            ]);
        } else {
            $video->update([
                'status' => true
            ]);
        }
        notify()->success("Video status successfully updated", "Success");
        return back();
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('admin.video.form', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
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

        } else {
            $thumbnailName = $video->thumbnail;
        }
        
        
        $video->update([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title),
            'thumbnail' => $thumbnailName,
            'link'      => $request->link
        ]);

        notify()->success("Video successfully updated", "Success");
        return redirect()->route('admin.video.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
        notify()->success("Video successfully deleted", "Success");
        return back();
    }
}
