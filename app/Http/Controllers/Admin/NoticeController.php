<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $noticed = Notice::latest('id')->get();
        return view('admin.notice.index', compact('noticed'));
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
            'title'       => 'required|string|max:255|unique:notices,title',
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048|mimes:jpeg,jpg,png,bmp'
        ]);
        $image = $request->file('image');
        if ($image) {
            $currentDate = Carbon::now()->toDateString();
            $imageName   = $currentDate.'-'.uniqid().'.'.$image->getClientOriginalExtension();

            if (!file_exists('uploads/notice')) {
                mkdir('uploads/notice', 0777, true);
            }
            $image->move(public_path('uploads/notice'), $imageName);

        }
        
        Notice::create([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'image'       => $imageName ?? 'default.png'
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Notice added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Notice $notice
     * @return Response
     */
    public function show(Notice $notice)
    {
        return response()->json($notice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Notice $notice
     * @return Response
     */
    public function update(Request $request, Notice $notice)
    {
        $this->validate($request, [
            'title'       => 'required|string|max:255|unique:notices,title,'.$notice->id,
            'description' => 'required|string',
            'image'       => 'nullable|image|max:2048|mimes:jpeg,jpg,png,bmp'
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

        }

        $notice->update([
            'title'       => $request->title,
            'slug'        => Str::slug($request->title),
            'description' => $request->description,
            'image'       => $imageName ?? $notice->image
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Notice updated successfully'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Notice $notice
     * @return Response
     */
    public function destroy(Notice $notice)
    {
        if (file_exists('uploads/notice/'.$notice->image)) {
            unlink('uploads/notice/'.$notice->image);
        }
        $notice->delete();

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Notice deleted successfully'
        ]);
    }

    
    /**
     * Update the specified resource from storage.
     *
     * @param  mixed $id
     * @return void
     */
    public function status($id)
    {
        $notice = Notice::findOrFail($id);

        $status = $notice->status ? false:true;
        $notice->status = $status;
        $notice->save();

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Notice status successfully updated'
        ]);
    }
}
