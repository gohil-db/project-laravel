<?php

namespace App\Http\Controllers;

use App\Models\HeaderSlider;
use Illuminate\Http\Request;


class HeaderSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = HeaderSlider::all();
        return view('content.admin.admin-header-slider', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only('image');
        
         if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/slider'), $filename);
            $data['image'] = 'uploads/slider/' . $filename;
        }

          HeaderSlider::create($data);

        // return redirect()->route('property-types.index')->with('success', 'Property type created successfully.');
         return redirect()->back()->with('success', 'Image added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HeaderSlider  $headerSlider
     * @return \Illuminate\Http\Response
     */
    public function show(HeaderSlider $headerSlider)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HeaderSlider  $headerSlider
     * @return \Illuminate\Http\Response
     */
    public function edit(HeaderSlider $headerSlider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HeaderSlider  $headerSlider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HeaderSlider $headerSlider)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HeaderSlider  $headerSlider
     * @return \Illuminate\Http\Response
     */
    public function destroy(HeaderSlider $headerSlider)
    {
        if ($headerSlider->image && file_exists(public_path($headerSlider->image))) {
            unlink(public_path($headerSlider->image));
        }

        $headerSlider->delete();
        return redirect()->back()->with('success', 'Image deleted successfully.');
        // return redirect()->route('header-sliders')->with('success', 'Slider deleted successfully.');
    }
}
