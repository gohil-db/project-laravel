<?php

namespace App\Http\Controllers;

use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\Property;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = PropertyType::paginate(10);
        
        return view('content.admin.property-types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.admin.property-types.create');
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $data = $request->only('name', 'description');
         if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/property_types'), $filename);
            $data['type_img'] = 'uploads/property_types/' . $filename;
        }

        PropertyType::create($data);

        return redirect()->route('admin-properties-types-list')->with('success', 'Property type created successfully.');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyType $propertyType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyType $propertyType)
    {
        return view('content.admin.property-types.edit', compact('propertyType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyType $propertyType)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',            
        ]);
        $data = $request->only('name', 'description');
         if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/property_types'), $filename);
            $data['type_img'] = 'uploads/property_types/' . $filename;
        }

        $propertyType->update($data);
        return redirect()->route('admin-properties-types-list')->with('success', 'Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PropertyType  $propertyType
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyType $propertyType)
    {
         if ($propertyType->type_img && file_exists(public_path($propertyType->type_img))) {
            unlink(public_path($propertyType->type_img));        
        }
       $propertyType->delete();
       return redirect()->back()->with('success', 'Property type deleted successfully.');
        // return redirect()->route('property-types.index')
        //     ->with('success', 'Property type deleted successfully.');
    }
    public function propertyType()
    {
       
        $types = PropertyType::withCount(['properties' => function ($q) { $q->where('status', 1); }])->get();
        $properties = Property::all()->where('status',1);
        return view('property-type',compact('types','properties')); 
        
    }
    
    // Show all properties of a specific type
    public function propertyByType($slug)
    {
        // Find type by name (like "Apartment" or "Villa")
        $type_slug = PropertyType::where('name', $slug)->firstOrFail();
        // Get properties belonging to that type
        $properties = Property::where('type_id', $type_slug->id)->where('status', 1)->latest()->get();        
        $types = PropertyType::withCount(['properties' => function ($q) { $q->where('status', 1); }])->get();

        return view('property-type', compact('properties', 'types','type_slug'));     
        
    }
}
