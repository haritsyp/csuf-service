<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use DB;

class ServiceController extends Controller
{
    public function index(){
    	$service = Service::get();
    	return response()->json($service);
	}

	public function store(Request $request){
		$service = new Service();
		$service->service_id = $request->service_id;
		$service->service_name =  $request->service_name;
		$service->save();
		return response()->json($service);
	}

	public function edit($id){
		$service = Service::find($id);
		return response()->json($service); 
	}

	public function update(Request $request, $id){
		$service = Service::find($id);
		$service->service_id = $request->service_id;
		$service->service_name =  $request->service_name;
		$service->save();
		return response()->json($service);
	}

	public function destroy($id){
		$service = Service::find($id)->delete();
		$service = Service::get();
		return response()->json($service);
	}

	public function getAPI(){
		$service = Service::all('service_id', 'service_name');		
		return response()->json(["result" => $service]);
	}

	
}
