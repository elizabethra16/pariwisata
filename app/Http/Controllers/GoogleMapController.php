<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FormMapRequest;
use App\Models\Boxmap;
class GoogleMapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boxmap = Boxmap::all();

        $dataMap  = Array();
        $dataMap['type']='FeatureCollection';
        $dataMap['features']=array();
       foreach($boxmap as $value){
                $feaures = array();
                $feaures['type']='Feature';
                $geometry = array("type"=>"Point","coordinates"=>[$value->lng, $value->lat]);
                $feaures['geometry']=$geometry;
                $properties=array('title'=>$value->title,"description"=>$value->description,'image'=>$value->Image );
                $feaures['properties']= $properties;
                array_push($dataMap['features'],$feaures);

       }
    //    dd($dataMap);
        return View('pages.google-map')->with('dataArray',json_encode($dataMap));
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
        $validated = $request->validate([
            
            'title' => 'required',
            'description' => 'required',
            'lng' => 'required',
            'lat' =>  'required',
            'image'=> 'required|file',
           ]);
           if($request->file('image')){
            $validated['image'] = $request->file('image')->store('images');
           
           }
       Boxmap::create($validated);
       return redirect('/google-map')->with('success',"Add map success!");


    }
}


