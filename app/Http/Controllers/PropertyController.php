<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\Setting;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $properties = Property::with('type')->get();
        return view('content.admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = PropertyType::all();
        return view('content.admin.properties.create', compact('types'));
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
            'pro_name' => 'required|string|max:255',
            'pro_address' => 'required|string|max:255',
            'pro_area' => 'required|string|max:100',
            'pro_bed' => 'required|integer|min:0',
            'pro_bath' => 'required|integer|min:0',
            'type_id' => 'required|exists:property_types,id',
            'pro_img' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data = $request->only([
            'pro_name', 'pro_address', 'pro_area', 'pro_bed', 'pro_bath', 'type_id','latitude', 'longitude'
        ]);

        if ($request->hasFile('pro_img')) {
            $file = $request->file('pro_img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/properties'), $filename);
            $data['pro_img'] = 'uploads/properties/' . $filename;
        }

        Property::create($data);

        return redirect()->route('properties.index')->with('success', 'Property added successfully.');
 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $setting = Setting::first();
        $types = PropertyType::all();
        $property = Property::with('type')->findOrFail($id);
        return view('details', compact('property','types','setting'));
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        $types = PropertyType::all();
        return view('content.admin.properties.edit', compact('property', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        $request->validate([
            'pro_name' => 'required|string|max:255',
            'pro_address' => 'required|string|max:255',
            'pro_area' => 'nullable|string|max:100',
            'pro_bed' => 'nullable|integer|min:0',
            'pro_bath' => 'nullable|integer|min:0',
            'type_id' => 'required|exists:property_types,id',
            'pro_img' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $data = $request->only([
            'pro_name', 'pro_address', 'pro_area', 'pro_bed', 'pro_bath', 'type_id','latitude', 'longitude'
        ]);

        if ($request->hasFile('pro_img')) {
            if ($property->pro_img && file_exists(public_path($property->pro_img))) {
                unlink(public_path($property->pro_img));
            }
            $file = $request->file('pro_img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/properties'), $filename);
            $data['pro_img'] = 'uploads/properties/' . $filename;
        }

        $property->update($data);

        // return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
        return redirect()->route('admin-property-list')->with('success', 'Property updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
         if ($property->pro_img && file_exists(public_path($property->pro_img))) {
            unlink(public_path($property->pro_img));
        }

        $property->delete();
        return redirect()->route('admin-property-list')->with('success', 'Property deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = Property::query();

        // Search property name
        if ($request->search) {
            $query->where('pro_name', 'LIKE', '%' . $request->search . '%');
        }

        // Property type filter
        if ($request->type_id) {
            $query->where('type_id', $request->type_id);
        }

        // Location using lat/lng → find properties within 10 km
        if ($request->lat && $request->lng) {
            $lat = $request->lat;
            $lng = $request->lng;
            $radius = 10; // kilometers

            $query->selectRaw("*, 
                (6371 * acos(cos(radians($lat)) 
                * cos(radians(latitude)) 
                * cos(radians(longitude) - radians($lng)) 
                + sin(radians($lat)) 
                * sin(radians(latitude)))) AS distance")
                ->having("distance", "<", $radius)
                ->orderBy("distance");
        }

        $searchProperties = $query->get();
        $setting = Setting::first();
        $types = PropertyType::withCount('properties')->get();
        $properties = Property::all();
        return view('search-result', compact('properties','searchProperties','types','setting'));
    }

}
