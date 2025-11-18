<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PropertyType;
use App\Models\PropertyAgent;
use App\Models\HeaderSlider;
use App\Models\Setting;
use App\Models\Property;
use App\Models\Testimonial;
use App\Models\Builder;

class HomeController extends Controller
{
    public function index()
    {              
     
        $types = PropertyType::withCount(['properties' => function ($q) { $q->where('status', 1); }])->get();
        // $sliders = HeaderSlider::all();
        $topSlidersProperties = Property::where('display_top', 1)->where('status', 1)->get();
        $properties = Property::where('status',1)->orderBy('id', 'desc')->limit(6)->get();
        $testimonials = Testimonial::all();
        $propertyAgents = PropertyAgent::all();
        $propertyBuilders = Builder::all();


        return view('index',compact('types','properties','topSlidersProperties','testimonials','propertyAgents','propertyBuilders')); // resources/views/index.blade.php
    }

    public function about()
    {
        // $setting = Setting::first();
        $types = PropertyType::withCount('properties')->get();
        $properties = Property::all();
        return view('about',compact('types','properties')); // resources/views/about.blade.php
    }

    public function contact()
    {
        // $setting = Setting::first();
        $types = PropertyType::withCount('properties')->get();
        $properties = Property::all();
        return view('contact',compact('types','properties')); // resources/views/contact.blade.php
    }
    public function propertyList()
    {
        // $setting = Setting::first();
        $types = PropertyType::withCount('properties')->get();
        $properties = Property::where('status', 1)->paginate(6);    
        return view('property-list',compact('types','properties')); // resources/views/contact.blade.php
    }
    public function propertyAgent()
    {
        $setting = Setting::first();
        $types = PropertyType::withCount('properties')->get();
        $properties = Property::all();
        $propertyAgents = PropertyAgent::all();
        return view('property-agent',compact('types','properties','propertyAgents')); // resources/views/contact.blade.php
    }

    public function getFilterPropertiesAjax(Request $request)
    {
        $filter = $request->filter;    
        $query = Property::with('type')->where('status', 1);

        if ($filter === 'featured') {
            $query->where('featured', 1);
        } elseif ($filter === 'sell') {
            $query->where('for_sell', 1);
        } elseif ($filter === 'rent') {
            $query->where('for_rent', 1);
        }

        $properties = $query->orderBy('id', 'desc')->limit(9)->get();

        return response()->json($properties);
    }

   
}
