<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\PropertyImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Inquiry;
use App\Models\PropertyVideo;
use App\Models\PropertyAgent;
use Illuminate\Support\Facades\File;

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
            'for_sell' => 'nullable|boolean',
            'for_rent' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
           
        ]);

        $data = $request->only([
            'pro_name', 'pro_address', 'pro_area', 'pro_bed', 'pro_bath', 'type_id','latitude', 'longitude','description'
        ]);

        if ($request->hasFile('pro_img')) {
            $file = $request->file('pro_img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/properties'), $filename);
            $data['pro_img'] = 'uploads/properties/' . $filename;
        }
        // Convert checkboxes (unchecked = 0)
        $data['for_sell'] = $request->has('for_sell');
        $data['for_rent'] = $request->has('for_rent');
        $data['featured'] = $request->has('featured');

        if ($request->hasFile('catalog')) {
            $file = $request->file('catalog');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/catalog'), $filename);
            $data['catalog'] = 'uploads/catalog/' . $filename;         
        }

         $property = Property::create($data);

       // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {                
                $filename = time() . '_' . Str::random(8) . '.' . $imageFile->getClientOriginalExtension();             
                $imageFile->move(public_path('uploads/property_images'), $filename);       
                $property->images()->create([
                    'image' => 'uploads/property_images/' . $filename
                ]);
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $videoFile) {
                $filename = time() . '_' . Str::random(6) . '.' . $videoFile->getClientOriginalExtension();
                $videoFile->move(public_path('uploads/property_videos'), $filename);

                $property->videos()->create([
                    'video' => 'uploads/property_videos/' . $filename
                ]);
            }
        }

        // OR for YouTube links:
        if ($request->filled('video_links')) {
            $links = explode(',', $request->video_links);
            foreach ($links as $link) {
                $property->videos()->create(['video' => trim($link)]);
            }
        }

        return redirect()->route('admin-property-list')->with('success', 'Property added successfully.');
 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $types = PropertyType::all();
        $property = Property::with('type')->findOrFail($id);
        $properties = Property::with('type')->get(); 
        $propertyAgents = PropertyAgent::all();        
        return view('details', compact('properties','property','types','propertyAgents'));
      
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
            'for_sell' => 'nullable|boolean',
            'for_rent' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'pro_name', 'pro_address', 'pro_area', 'pro_bed', 'pro_bath', 'type_id','latitude', 'longitude','description'
        ]);
         // Convert checkboxes (unchecked = 0)
        $data['for_sell'] = $request->has('for_sell');
        $data['for_rent'] = $request->has('for_rent');
        $data['featured'] = $request->has('featured');

        if ($request->hasFile('pro_img')) {
            if ($property->pro_img && file_exists(public_path($property->pro_img))) {
                unlink(public_path($property->pro_img));
            }
            $file = $request->file('pro_img');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/properties'), $filename);
            $data['pro_img'] = 'uploads/properties/' . $filename;
        }
         if ($request->hasFile('catalog')) {
            $file = $request->file('catalog');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/catalog'), $filename);
            $data['catalog'] = 'uploads/catalog/' . $filename;         
        }
       
        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {                
                $filename = time() . '_' . Str::random(8) . '.' . $imageFile->getClientOriginalExtension();             
                $imageFile->move(public_path('uploads/property_images'), $filename);       
                $property->images()->create([
                    'image' => 'uploads/property_images/' . $filename
                ]);
            }
        }

        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $videoFile) {
                $filename = time() . '_' . Str::random(6) . '.' . $videoFile->getClientOriginalExtension();
                $videoFile->move(public_path('uploads/property_videos'), $filename);

                $property->videos()->create([
                    'video' => 'uploads/property_videos/' . $filename
                ]);
            }
        }        

        // OR for YouTube links:
        if ($request->filled('video_links')) {
            $links = explode(',', $request->video_links);
            foreach ($links as $link) {
                $property->videos()->create(['video' => trim($link)]);
            }
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
        // Delete catalog
        if ($property->catalog && file_exists(public_path($property->catalog))) {
            unlink(public_path($property->catalog));
        }
        // Delete images
        foreach ($property->images as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
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

    public function storeInquiry(Request $request, $propertyId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:15',
            'city' => 'nullable|string|max:255',
        ]);

        Inquiry::create([
            'property_id' => $propertyId,
            'name' => $request->name,
            'number' => $request->number,
            'city' => $request->city,
        ]);

        return redirect()->back()->with('success', 'Your inquiry has been submitted successfully!');
    }

    // public function deleteVideo($id, Request $request)
    // {
    //     $video = PropertyVideo::findOrFail($id);

    //     if ($video->video && File::exists(public_path($video->video))) {
    //         File::delete(public_path($video->video));
    //     }

    //     $video->delete();

    //     if ($request->ajax()) {
    //         return response()->json(['success' => true]);
    //     }

    //     return back()->with('success', 'Video deleted successfully.');
    // }

    public function deleteVideo($id)
    {
        $video = PropertyVideo::findOrFail($id);

        // Delete video file if it exists and is not a YouTube link
        if ($video->video && File::exists(public_path($video->video))) {
            File::delete(public_path($video->video));
        }

        $video->delete();

        return redirect()->back()->with('success', 'Video deleted successfully.');
    }

    public function deleteImage22($id)
    {
        try {
        $image = PropertyImage::findOrFail($id);

        // Delete the file if it exists
        if (file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        // Delete from database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting image', 'error' => $e->getMessage()]);
        }
    }

    public function deleteImage($id)
    {
        try {
            $image = PropertyImage::findOrFail($id);

            if (file_exists(public_path($image->image))) {
                unlink(public_path($image->image));
            }

            $image->delete();

            return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting image',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function inquiriesList()
    {
        // $inquiries = Inquiry::with('property');
        $inquiries = Inquiry::all();
       
        return view('content.admin.inquiries.index', compact('inquiries'));
    }

    public function destroyInquiry(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->back()->with('success', 'Inquiry deleted successfully.');
    }
}
