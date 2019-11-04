<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poll;
use App\Exports\ServiceExport;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class PollController extends Controller
{

	public function store(Request $request){
		$name = "success";
		$poll = new Poll();
		$poll->poll_date = Carbon::now()->toDateTimeString();
		$poll->service_id = $request->service_id;
		$poll->value = $request->value;
		if($request->file('upload') != null){
			$id = DB::select("SHOW TABLE STATUS LIKE 'polls'")[0];
			$imgfile = $request->file('upload');
			$getFileExt   = $imgfile->getClientOriginalExtension();
			$uploadedFile =   $id->Auto_increment.'.'.$getFileExt;
			$imgfile->move(public_path('uploads'), $uploadedFile);
			$poll->poll_image = $uploadedFile;
		}
		$poll->save();
		return response()->json(["result" =>  public_path('uploads')]);
	}



	public function paginate(Request $request)
	{
		$polls = Poll::orderBy('poll_date', 'DESC')
		->where('poll_date','>=',$request->start_date)
		->where('poll_date','<=',$request->end_date)
		->paginate(request('limit', 20));

		if($request->service_id != ''){
			$polls = Poll::orderBy('poll_date', 'DESC')
			->where('poll_date','>=',$request->start_date)
			->where('poll_date','<=',$request->end_date)
			->where('service_id','=',$request->service_id)
			->paginate(request('limit', 20));
		}
		
		foreach ($polls as $key => $value) {
			if($value->value == 1){
				$polls[$key]->result = 'Sangat Puas';
			}else if($value->value == 2){
				$polls[$key]->result = 'Puas';
			}else if($value->value == 3){
				$polls[$key]->result = 'Cukup';
			}else if($value->value == 4){
				$polls[$key]->result = 'Kecewa';
			}
		}
		return response()->json($polls);
	}

	public function getExcel(Request $request){
		if(is_null($request->service_id)){
			$request->service_id = "";
		}
		if(is_null($request->start_date)){
			$request->start_date = "";
		}
		if(is_null($request->end_date)){
			$request->end_date = '';
		}
		$polls = Poll::orderBy('poll_date', 'DESC')
		->where('poll_date','>=',$request->start_date)
		->where('poll_date','<=',$request->end_date)
		->get();

		if($request->service_id != ''){
			$polls = Poll::orderBy('poll_date', 'DESC')
			->where('poll_date','>=',$request->start_date)
			->where('poll_date','<=',$request->end_date)
			->where('service_id','=',$request->service_id)
			->get();
		}

		foreach ($polls as $key => $value) {
			if($value->value == 1){
				$polls[$key]->result = 'Sangat Puas';
			}else if($value->value == 2){
				$polls[$key]->result = 'Puas';
			}else if($value->value == 3){
				$polls[$key]->result = 'Cukup';
			}else if($value->value == 4){
				$polls[$key]->result = 'Kecewa';
			}
		}
		return view('excel.poll',compact('polls'));
	}

	public function getExcelResult(Request $request){
		if(is_null($request->start_date) || !isset($request->start_date)){
			$polls = DB::select("SELECT cast(a.poll_date as date) as mydate, 
				(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 1 and service_id like '%$request->service_id%') as sangatpuas,
				(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 2 and service_id like '%$request->service_id%') as puas,
				(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 3 and service_id like '%$request->service_id%') as cukup,
				(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 4 and service_id like '%$request->service_id%') as kecewa
				FROM polls a where cast(a.poll_date as date)  GROUP BY mydate");
		}else{
			$polls = DB::select("SELECT cast(a.poll_date as date) as mydate, 
				(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 1 and service_id = '$request->service_id') as sangatpuas,
				(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 2 and service_id = '$request->service_id') as puas,
				(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 3 and service_id = '$request->service_id') as cukup,
				(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 4 and service_id = '$request->service_id') as kecewa
				FROM polls a where cast(a.poll_date as date) BETWEEN '$request->start_date' and '$request->end_date' GROUP BY mydate");
		}
		return view('excel.result',compact('polls'));
	}

	public function getResult(Request $request){
		$data = [];
		$result = DB::select("select count(*) as jumlah from polls where service_id like '%$request->service_id%'  GROUP by value");
		foreach ($result as $key => $value) {
			$data[$key] = $value->jumlah;
		}
		return response()->json($data);

	}

	public function getResultFilter(Request $request){
		$data = [];
		$result = DB::select("select value,count(*) as jumlah from polls where poll_date BETWEEN '$request->start_date' and '$request->end_date' and service_id like '%$request->service_id%' GROUP by value");
		for($i=0;$i<4;$i++){
			$data[$i] = 0;
			foreach ($result as $value) {
				if($value->value-1 == $i){
					$data[$i] = $value->jumlah;
				}
			}
		}
		return response()->json($data);

	}

	public function getResultTableFilter(Request $request){
		$result = DB::select("SELECT cast(a.poll_date as date) as mydate, 
			(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 1 and service_id = '$request->service_id') as sangatpuas,
			(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 2 and service_id = '$request->service_id') as puas,
			(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 3 and service_id = '$request->service_id') as cukup,
			(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 4 and service_id = '$request->service_id') as kecewa
			FROM polls a where cast(a.poll_date as date) BETWEEN '$request->start_date' and '$request->end_date' GROUP BY mydate");
		return response()->json($result);
	}

	public function getResultTable(Request $request){
		$result = DB::select("SELECT cast(a.poll_date as date) as mydate, 
			(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 1 and service_id like '%$request->service_id%') as sangatpuas,
			(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 2 and service_id like '%$request->service_id%') as puas,
			(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 3 and service_id like '%$request->service_id%') as cukup,
			(select count(*) from polls where cast(poll_date as date) = cast(a.poll_date as date) and value = 4 and service_id like '%$request->service_id%') as kecewa
			FROM polls a where cast(a.poll_date as date)  GROUP BY mydate");
		return response()->json($result);
	}

	public function destroy(Request $request){
		$poll = Poll::find($request->poll_id);
		$img = $poll->poll_image;
		$image_path = public_path('uploads/').$img;
        if (file_exists($image_path)) {
            @unlink($image_path);
        }
		$poll = Poll::find($request->poll_id)->delete();
		return response()->json(["result" => "success"]);
	}

	
}
