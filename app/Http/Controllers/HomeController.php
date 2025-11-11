<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PropertyType;
use App\Models\PropertyAgent;
use App\Models\HeaderSlider;
use App\Models\Setting;
use App\Models\Property;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        // $setting = Setting::first();
        // $types = PropertyType::all();        
        $types = PropertyType::withCount('properties')->get();
        $sliders = HeaderSlider::all();
        $properties = Property::all();
        $testimonials = Testimonial::all();
        $propertyAgents = PropertyAgent::all();

        return view('index',compact('types','properties','sliders','testimonials','propertyAgents')); // resources/views/index.blade.php
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
        $properties = Property::all();
        return view('property-list',compact('types','properties')); // resources/views/contact.blade.php
    }
    public function propertyAgent()
    {
        $setting = Setting::first();
        $types = PropertyType::withCount('properties')->get();
        $properties = Property::all();
        return view('property-agent',compact('types','properties')); // resources/views/contact.blade.php
    }
    public function propertyType()
    {
        // $setting = Setting::first();
        $types = PropertyType::withCount('properties')->get();
        $properties = Property::all();
        return view('property-type',compact('types','properties')); // resources/views/contact.blade.php
    }
}
