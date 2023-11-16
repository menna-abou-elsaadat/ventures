<?php

namespace App\Services;

use DB;

class ReportService{

	public static function report($starting_date,$ending_date)
	{
		$starting_date = date('Y-m-d',strtotime($starting_date));
		$ending_date = date('Y-m-d',strtotime($ending_date));

		return DB::select("call report (?,?) ", array($starting_date , $ending_date) );

	}
}
?>