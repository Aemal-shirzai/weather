<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class weatherController extends Controller
{
    public function search(Request $request){

		$content =  file_get_contents(
			"https://api.openweathermap.org/data/2.5/weather?q=$request->search_for&appid=b5a4d42e3484b8d5f68266bea63cb4e0",
			false,
			stream_context_create([
		        'http' => [
		            'ignore_errors' => true,
		        ],
    		])
		);

		$mainContent = json_decode($content,true);
		if($mainContent["cod"] == 200){
		    $cityName =  $mainContent["name"];
		    $country = $mainContent["sys"]["country"];
		    $mainCondition = $mainContent["weather"][0]['main'];
		    $description = $mainContent["weather"][0]["description"];
		    $icon = $mainContent["weather"][0]["icon"];
		    $degree = intval($mainContent["main"]["temp"] - 273);
		   	
		   	if($request->ajax()){
		   		return response()->json(["cityName"=>$cityName,"country"=>$country,"icon"=>$icon,"degree"=>$degree,"mainCondition"=>$mainCondition,"description"=>$description]);
		   	}else{
		   		return view("weather",compact("cityName" , "country" , "mainCondition" , "description" , "degree","icon"));
	    	}
	    }else{
	    	if($request->ajax()){
	    		return response()->json(["notFound"=>"No City Found"]);
	    	}else{
		    	$notFound = "No City Found!";
		    	return view("weather",compact('notFound'));
	    	}
	    }	
	    
    }
}
