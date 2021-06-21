<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.page.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Check validation
        $this->validate($request, [
            'name'  => 'required|string|unique:pages,name',
            'body'  => 'required|string'
        ]);

        // Store date
        Page::create([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'body'   => $request->body
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Page successfully added'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @return Response
     */
    public function show(Page $page)
    {
        return response()->json($page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @return Response
     */
    public function edit(Page $page)
    {
        return view('admin.page.form', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Page $page
     * @return Response
     */
    public function update(Request $request, Page $page)
    {
        // Check validation
        $this->validate($request, [
            'name'  => 'required|string|unique:pages,name,'.$page->id,
            'body'  => 'required|string'
        ]);

        // Store date
        $page->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'body' => $request->body,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
            'status' => $request->filled('status'),
        ]);

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Page successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return Response
     */
    public function destroy(Page $page)
    {
        $page->delete();
        return response()->json([
            'alert'   => 'Success',
            'message' => 'Page successfully deleted'
        ]);
    }

    public function status($id){
        $page   = Page::findOrFail($id);
        $status = $page->status ? false:true;
        $page->status = $status;
        $page->save();

        return response()->json([
            'alert'   => 'Success',
            'message' => 'Page status successfully updated'
        ]);
    }
}
