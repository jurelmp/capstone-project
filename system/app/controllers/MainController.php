<?php

class MainController extends BaseController {

	// public function getIndex(){
	// 	return View::make('home.news');
	// }

	public function getNews(){
		$sql = "SELECT a.firstname, a.lastname, a.midname, n.*
				FROM accounts AS a
				RIGHT JOIN news AS n
				ON a.id = n.account_id
				ORDER BY n.created_at DESC";

		$sql2 = "SELECT * FROM news AS n
				ORDER BY n.created_at DESC
				LIMIT 5";

		$news = DB::select($sql);
		$latest = DB::select($sql2);

		return View::make('home.news')
			->with('h_news', $news)
			->with('latest', $latest);
	}


	public function getViewnews($id){
		$sql = "SELECT a.firstname, a.midname, a.lastname, n.*
				FROM accounts AS a
				RIGHT JOIN news AS n
				ON a.id = n.account_id
				WHERE n.id = ?";
		$news = DB::select($sql, array($id));

		return View::make('home.view_news')
			->with('v_news', $news);
	}

	public function getTracer(){
		$regions = Region::all();
		$departments = Department::all();

		return View::make('home.tracer_form')
			->with('regions', $regions)
			->with('departments', $departments);
	}

	public function postProvince(){

		$region_id = $_POST['region_id'];
		$sql = "SELECT * FROM provinces WHERE region_id = " . $region_id;
		$provinces = DB::select($sql);

		return json_encode($provinces);
	}

	public function postCourse(){

		$dept_id = $_POST['dept_id'];
		$sql = "SELECT * FROM course WHERE dept_id = " . $dept_id;
		$courses = DB::select($sql);

		return json_encode($courses);
	}
}