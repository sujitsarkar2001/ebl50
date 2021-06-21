<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceMedia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest('id')->get();
        return view('admin.service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service.create');
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
            'contents' => 'required|string',
            'photos'   => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,jpg,png,bmp',
            'videos'   => 'nullable|array',
            'videos.*' => 'file|mimes:mp4,ogm,wmv,webm,ogv,mov,mpeg,m4v,avi',
        ]);

        $service = new Service();
        $service->contents = $request->contents;
        $service->save();

        $photos = $request->file('photos');

        if ($photos) {

            foreach ($photos as $photo) {
                $currentDate = Carbon::now()->toDateString();
                $photoName   = $currentDate.'-'.uniqid().'.'.$photo->getClientOriginalExtension();

                if (!file_exists('uploads/service/photos')) {
                    mkdir('uploads/service/photos', 0777, true);
                }
                $photo->move(public_path('uploads/service/photos'), $photoName);

                ServiceMedia::create([
                    'service_id' => $service->id,
                    'type'       => 'photo',
                    'name'       => $photoName
                ]);
            }
        }

        $videos = $request->file('videos');

        if ($videos) {

            foreach ($videos as $video) {
                $currentDate = Carbon::now()->toDateString();
                $videoName   = $currentDate.'-'.uniqid().'.'.$video->getClientOriginalExtension();

                if (!file_exists('uploads/service/videos')) {
                    mkdir('uploads/service/videos', 0777, true);
                }
                $video->move(public_path('uploads/service/videos'), $videoName);

                ServiceMedia::create([
                    'service_id' => $service->id,
                    'type'       => 'video',
                    'name'       => $videoName
                ]);
            }
        }

        notify()->success("Service successfully added to server", "Congratulations");

        return redirect()->route('admin.service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        foreach ($service->service_media as $data) {
            
            if ($data->type == 'video') {

                if (file_exists('uploads/service/videos/'.$data->name)) {
                    unlink('uploads/service/videos/'.$data->name);
                }
            
            } else {
            
                if (file_exists('uploads/service/photos/'.$data->name)) {
                    unlink('uploads/service/photos/'.$data->name);
                }
            }
        }
        
        $service->delete();

        notify()->success("Service deleted successfully", "Congratulations");

        return back();
    }
}
