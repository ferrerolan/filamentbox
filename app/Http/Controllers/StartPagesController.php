<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class StartPagesController extends Controller
{
    public function getStartpagesData(){

        $slider = Property::where('visible', '=', 1)
        ->withWhereHas('media', function ($query){
            $query->where('collection_name', '=', 'slider');
        })
        ->where('slider', '=', 1)
        ->orderBy('updated_at', 'desc')
        ->take(3)
        ->get();

        $newProject = Property::where('visible', '=', 1)
        ->withWhereHas('media', function ($query){
            $query->where('collection_name', '=', 'hauptbilder')
            ->orderBy('order_column', 'asc');
        })
        ->orderBy('updated_at', 'desc')
        ->take(4)
        ->get();

        // dd($newProject);
        // dd($slider);

        return view('pages.startpage', [
            'slider' => $slider,
            'newProject' => $newProject
        ]);
    
    }
}
