<?php

namespace App\Http\Controllers;

use App\Models\PropertyAgent;
use Illuminate\Http\Request;

class PropertyAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $agents = PropertyAgent::all();
        return view('content.admin.agents.index', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.admin.agents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'fullname' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'fb_link' => 'nullable|url',
            'insta_link' => 'nullable|url',
            'x_link' => 'nullable|url',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['fullname', 'designation', 'description', 'fb_link', 'insta_link', 'x_link','image']);      

        if ($request->hasFile('image')) {     
            $file = $request->file('image');  
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/agents'), $filename);
            $data['image'] = 'uploads/agents/' . $filename;
        }
        PropertyAgent::create($data);

        return redirect()->route('property-agents.index')->with('success', 'Agent added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PropertyAgent  $propertyAgent
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyAgent $propertyAgent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PropertyAgent  $propertyAgent
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyAgent $propertyAgent)
    {
        return view('content.admin.agents.edit', compact('propertyAgent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PropertyAgent  $propertyAgent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyAgent $propertyAgent)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'fb_link' => 'nullable|url',
            'insta_link' => 'nullable|url',
            'x_link' => 'nullable|url',
        ]);


        $data = $request->only(['fullname', 'designation', 'description', 'fb_link', 'insta_link', 'x_link','image']);      

        if ($request->hasFile('image')) {     
            $file = $request->file('image');  
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/agents'), $filename);
            $data['image'] = 'uploads/agents/' . $filename;
        }
        // PropertyAgent::update($data);
        $propertyAgent->update($data);

        return redirect()->route('admin-agents-list')->with('success', 'Agent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PropertyAgent  $propertyAgent
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyAgent $propertyAgent)
    {
         if ($propertyAgent->image && file_exists(public_path($propertyAgent->image))) {
            unlink(public_path($propertyAgent->image));        
        }

        $propertyAgent->delete();
        return redirect()->back()->with('success', 'Agent deleted successfully.');
    }
}
