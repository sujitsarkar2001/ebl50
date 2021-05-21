<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticed = Notice::latest('id')->get();
        return view('admin.notice.index', compact('noticed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.notice.form');
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
            'title'       => 'required|string|max:255|unique:notices,title',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:1024|mimes:jpeg,jpg,png,bmp'
        ]);
        $image = $request->file('image');
        if ($image) {
            $currentDate = Carbon::now()->toDateString();
            $imageName   = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!file_exists('uploads/notice')) {
                mkdir('uploads/notice', 0777, true);
            }
            $image->move(public_path('uploads/notice'), $imageName);

        } else {
            $imageName = 'default.png';
        }
        
        Notice::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'image'       => $imageName
        ]);

        notify()->success("Notice successfully added", "Success");
        
        return redirect()->route('admin.notice.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        return view('admin.notice.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        return view('admin.notice.form', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        $this->validate($request, [
            'title'       => 'required|string|max:255|unique:notices,title,'.$notice->id,
            'description' => 'required|string',
            'image'       => 'nullable|image|max:1024|mimes:jpeg,jpg,png,bmp'
        ]);
        $image = $request->file('image');
        if ($image) {
            $currentDate = Carbon::now()->toDateString();
            $imageName   = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();
            
            if (file_exists('uploads/notice/'.$notice->image)) {
                unlink('uploads/notice/'.$notice->image);
            }

            if (!file_exists('uploads/notice')) {
                mkdir('uploads/notice', 0777, true);
            }
            $image->move(public_path('uploads/notice'), $imageName);

        } else {
            $imageName = $notice->image;
        }
        
        $notice->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'image'       => $imageName
        ]);

        notify()->success("Notice successfully updated", "Success");
        
        return redirect()->route('admin.notice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notice $notice)
    {
        if (file_exists('uploads/notice/'.$notice->image)) {
            unlink('uploads/notice/'.$notice->image);
        }
        $notice->delete();
        
        notify()->success("Notice deleted successfully", "Success");
        
        return back();
    }

    /**
     * Update the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */

    public function status($id)
    {
        $notice = Notice::findOrFail($id);
        
        if ($notice->status == true) {
            $notice->update([
                'status' => false
            ]);
        } else {
            $notice->update([
                'status' => true
            ]);
        }
        notify()->success("Notice status successfully updated", "Success");
        
        return back();
    }
}
