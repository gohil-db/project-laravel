<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Builder;
use App\Models\PropertyType;
use App\Models\Property;

class BuilderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $builders = Builder::paginate(10);
        return view('content.admin.builders.index', compact('builders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.admin.builders.create');
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
            'fullname' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required|string',
            'fb_link' => 'nullable|url',
            'insta_link' => 'nullable|url',
            'x_link' => 'nullable|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['fullname', 'business_name', 'phone', 'description', 'fb_link', 'insta_link', 'x_link','image']);      

        if ($request->hasFile('image')) {     
            $file = $request->file('image');  
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/builders'), $filename);
            $data['image'] = 'uploads/builders/' . $filename;
        }
        Builder::create($data);

        return redirect()->route('property-builders.index')->with('success', 'Builder added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $types = PropertyType::withCount('properties')->get();       
         $propertyBuilders = Builder::where('id', $slug)
                      ->with(['properties' => function($q){
                          $q->where('status', 1); // only active properties
                      }])->firstOrFail();
        return view('property-builder-details', compact('propertyBuilders','types' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Builder $propertyBuilder)  
    {      
    
        return view('content.admin.builders.edit', compact('propertyBuilder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Builder $propertyBuilder)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'required|string',
            'fb_link' => 'nullable|url',
            'insta_link' => 'nullable|url',
            'x_link' => 'nullable|url',
        ]);


        $data = $request->only(['fullname', 'business_name', 'phone', 'description', 'fb_link', 'insta_link', 'x_link','image']);      

        if ($request->hasFile('image')) {     
            $file = $request->file('image');  
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/builders'), $filename);
            $data['image'] = 'uploads/builders/' . $filename;
        }
        
        $propertyBuilder->update($data);

        return redirect()->route('admin-builders-list')->with('success', 'Builder updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Builder $propertyBuilder)
    {
        if ($propertyBuilder->image && file_exists(public_path($propertyBuilder->image))) {
            unlink(public_path($propertyBuilder->image));        
        }

        $propertyBuilder->delete();
        return redirect()->back()->with('success', 'Builder deleted successfully.');
    }

    public function propertyBuilderList()
    {
        
        $types = PropertyType::withCount('properties')->get();
        $properties = Property::all();
        $propertyBuilders = Builder::all();
        return view('property-builder',compact('types','properties','propertyBuilders')); 
    }

}
