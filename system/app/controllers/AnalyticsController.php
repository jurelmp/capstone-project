<?php

class AnalyticsController extends BaseController {

	// public function __construct(){
	// 	$this->beforeFilter('admin');
	// }

	public function getIndex(){
		return 'Analytics';
	}

	public function getCurriculum(){
		$departments = Department::all();

		return View::make('analytics.curriculum')
					->with('departments', $departments);
	}

	public function getAlumniResponse(){
		$course = DB::select("SELECT c.*, d.name AS 'd_name', d.id AS 'dept_id' FROM course AS c INNER JOIN departments AS d ON d.id = c.dept_id ORDER BY c.dept_id");
		return View::make('analytics.alumni_response')
					->with('course', $course);
	}

	public function getCurriculumDevelopment($dept, $from, $to){
		$total = DB::select("SELECT COUNT(id) AS 'count' FROM alumni WHERE is_confirmed = 1");
		$categories = array();
		$suggestion = array();
		$series = array();
		$choices = DB::select('SELECT * FROM survey_choices WHERE question_id = ?', array(27));
		$names = array();
		$graduates = $total{0}->count;

		if($dept == 0){
			foreach($choices as $choice){
				$temp_total = 0;
				$temp_data = array();
				for($j = $from; $j <= $to; $j++){
					$sql = "SELECT COUNT(tr.choice_id) AS count
							FROM alumni_tracer AS tr
							INNER JOIN alumni AS al
							ON al.id = tr.alumni_id
							WHERE al.year_graduated = ? AND tr.question_id AND tr.choice_id = ?";

					$result = DB::select($sql, array($j, $choice->id));

					if($result == null or $result{0}->count == 0){
						array_push($temp_data, 0);
					} else{
						$temp_total += $result{0}->count;
						array_push($temp_data, $result{0}->count);
					}

				}
				array_push($suggestion, $temp_total);
				array_push($series, $temp_data);
			}
		} else{
			foreach($choices as $choice){
				$temp_data = array();
				for($j = $from; $j <= $to; $j++){
					$sql = "SELECT COUNT(tr.choice_id) AS count
							FROM alumni_tracer AS tr
							INNER JOIN alumni AS al
							ON al.id = tr.alumni_id
							INNER JOIN course AS crs
							ON crs.id = al.course_id
							INNER JOIN departments AS dept
							ON dept.id = crs.dept_id
							WHERE al.year_graduated = ? AND tr.question_id AND tr.choice_id = ? AND dept.id = ?";

					$result = DB::select($sql, array($j, $choice->id, $dept));

					if($result == null or $result{0}->count == 0){
						array_push($temp_data, 0);
					} else{
						array_push($temp_data, $result{0}->count);
					}

				}
				array_push($series, $temp_data);
			}
		}

		foreach($choices as $choice){
			array_push($names, $choice->choice);
		}

		for ($i=$from; $i <= $to ; $i++) { 
			array_push($categories, $i);
		}

		return View::make('analytics.curriculum_development')
					->with('categories', $categories)
					->with('series', $series)
					->with('names', $names)
					->with('graduates', $graduates)
					->with('no_suggestion', $suggestion);
	}

	public function getGraphResponse($course, $from, $to){

		$categories = array();
		$response = array();
		$graduates = array();

		if($course == 0){

			for ($i=$from; $i <= $to; $i++) { 
				$sql1 = "SELECT COUNT(al.id) AS 'count'
						FROM alumni AS al
						WHERE al.year_graduated = ? AND al.is_confirmed = 1";
				$sql2 = "SELECT COUNT(sm.id) AS 'count'
						FROM student_master AS sm
						WHERE sm.batch = ?";

				$results1 = DB::select($sql1, array($i));
				$results2 = DB::select($sql2, array($i));

				if($results1 == null){
					array_push($response, 0);
				} else{
					array_push($response, $results1{0}->count);
				}
				if($results2 == null){
					array_push($response, 0);
				} else{
					array_push($graduates, $results2{0}->count);
				}
			}

		} else{
			for ($i=$from; $i <= $to; $i++) { 
				$sql1 = "SELECT COUNT(al.id) AS 'count'
						FROM alumni AS al
						WHERE al.year_graduated = ? AND al.is_confirmed = 1 AND al.course_id = ?";
				$sql2 = "SELECT COUNT(sm.id) AS 'count'
						FROM student_master AS sm
						WHERE sm.batch = ? AND sm.course_id = ?";

				$results1 = DB::select($sql1, array($i, $course));
				$results2 = DB::select($sql2, array($i, $course));

				if($results1 == null){
					array_push($response, 0);
				} else{
					array_push($response, $results1{0}->count);
				}
				if($results2 == null){
					array_push($response, 0);
				} else{
					array_push($graduates, $results2{0}->count);
				}
			}
		}

		
		for($i = $from; $i <= $to; $i++){
			array_push($categories, "".$i."");
		}

		return View::make('analytics.responses')
					->with('categories', $categories)
					->with('response', $response)
					->with('graduates', $graduates);
	}

	public function getReasonForTakingUc(){
		$filter = $_GET['filter_dept'];

		if($filter == 0){
			$sql = "SELECT DISTINCT ch.id, ch.choice, COUNT(tr.choice_id) AS 'count'
					FROM alumni_tracer AS tr
					INNER JOIN alumni AS al
					ON al.id = tr.alumni_id
					INNER JOIN survey_choices AS ch
					ON ch.id = tr.choice_id
					WHERE tr.question_id = ? AND al.is_confirmed = ?
					GROUP BY tr.choice_id";

			$n_graduates = DB::select("SELECT COUNT(id) AS 'count' FROM alumni WHERE is_confirmed = ?", array(1));

			$data = array();
			$results = DB::select($sql, array(1, 1));
			$reasons = DB::select("SELECT * FROM survey_choices WHERE question_id = ?", array(1));

			foreach($results as $rslt){
				$p = ($rslt->count / $n_graduates{0}->count)*100;

				$rslt->count = round($p, 2);
			}
		} else{
			
			$sql = "SELECT DISTINCT ch.id, ch.choice, COUNT(tr.choice_id) AS 'count'
					FROM alumni_tracer AS tr
					INNER JOIN alumni AS al
					ON al.id = tr.alumni_id
					INNER JOIN survey_choices AS ch
					ON ch.id = tr.choice_id
					INNER JOIN course AS crs
					ON crs.id = al.course_id
					INNER JOIN departments AS dept
					ON dept.id = crs.dept_id
					WHERE tr.question_id = ? AND al.is_confirmed = ? AND dept.id = ?
					GROUP BY tr.choice_id";

			$n_graduates = DB::select("SELECT COUNT(al.id) AS 'count' 
										FROM alumni AS al
										INNER JOIN course AS crs
										ON crs.id = al.course_id
										INNER JOIN departments AS dept
										ON dept.id = crs.dept_id 
										WHERE al.is_confirmed = ? AND dept.id = ?", array(1, $filter));

			$data = array();
			$results = DB::select($sql, array(1, 1, $filter));
			$reasons = DB::select("SELECT * FROM survey_choices WHERE question_id = ?", array(1));

			foreach($results as $rslt){
				$p = ($rslt->count / $n_graduates{0}->count)*100;

				$rslt->count = round($p, 2);
			}
		}


		return View::make('analytics.reasons_for_entering')
					->with('reasons', $reasons)
					->with('results', $results)
					->with('n_graduates', $n_graduates);
	}

	public function getSkillsAssessment(){
		$departments = Department::all();

		return View::make('analytics.skills_assessment')
					->with('departments', $departments);
	}
	
	public function getSkills($dept, $from, $to){

		if($dept == 0){
			$skills = DB::select("SELECT * FROM survey_choices WHERE question_id = 22");
			$skills_data = array();
			$names = array();
		
			for($j = 0; $j<count($skills);$j++){
				$index = 0;
				$temp_data = array();
				
				for($i = $from; $i <= $to; $i++){
					$total_count = DB::select("SELECT COUNT(id) AS 'count' FROM alumni WHERE is_confirmed = ? AND year_graduated = ?", array(1, $i));

					$sql = "SELECT COUNT(tr.choice_id) AS 'count', ch.choice, ch.id
							FROM alumni_tracer AS tr
							INNER JOIN survey_questions AS sq
							ON sq.id = tr.question_id
							INNER JOIN survey_choices AS ch
							ON ch.id = tr.choice_id
							INNER JOIN alumni AS al
							ON al.id = tr.alumni_id
							WHERE sq.id = 22 AND ch.id = ? AND al.year_graduated = ?
							GROUP BY tr.choice_id";

					$result = DB::select($sql, array($skills{$j}->id, $i));

					if($result == null){
						$temp_data{$index} = 0;
					} else{
						$m = (int)$result{0}->count;
						$p = (int)$total_count{0}->count;
						// $temp_data{$index} = ($m / $p) * 100;
						$temp_data{$index} = $m;
					}
					$index++;
				}
				
				$skills_data[$j] = $temp_data;
				$names{$j} = $skills{$j}->choice;

			}
				
			$academic_years = array();
			$val = 0;
			for($i = $from; $i <= $to; $i++){
				$academic_years{$val} = $i;
				$val++;
			}

			return View::make('analytics.skills')
						->with('academic_years', $academic_years)
						->with('skills_data', $skills_data)
						->with('names', $names);
		} else {
			$skills = DB::select("SELECT * FROM survey_choices WHERE question_id = 22");
			$skills_data = array();
			$names = array();
		
			for($j = 0; $j<count($skills);$j++){
				$index = 0;
				$temp_data = array();
				
				for($i = $from; $i <= $to; $i++){
					$total_count = DB::select("SELECT COUNT(al.id) AS 'count' 
												FROM alumni AS al
												INNER JOIN course AS crs
					                            ON crs.id = al.course_id
					                            INNER JOIN departments AS dept
					                            ON dept.id = crs.dept_id
												WHERE is_confirmed = ? AND year_graduated = ? AND dept.id = ?", array(1, $i, $dept));

					$sql = "SELECT COUNT(tr.choice_id) AS 'count', ch.choice, ch.id
							FROM alumni_tracer AS tr
							INNER JOIN survey_questions AS sq
							ON sq.id = tr.question_id
							INNER JOIN survey_choices AS ch
							ON ch.id = tr.choice_id
							INNER JOIN alumni AS al
							ON al.id = tr.alumni_id
							INNER JOIN course AS crs
                            ON crs.id = al.course_id
                            INNER JOIN departments AS dept
                            ON dept.id = crs.dept_id
							WHERE sq.id = 22 AND ch.id = ? AND al.year_graduated = ? AND dept.id = ?
							GROUP BY tr.choice_id";

					$result = DB::select($sql, array($skills{$j}->id, $i, $dept));

					if($result == null){
						$temp_data{$index} = 0;
					} else{
						$m = (int)$result{0}->count;
						$p = (int)$total_count{0}->count;
						// $temp_data{$index} = ($m / $p) * 100;
						$temp_data{$index} = $m;
					}
					$index++;
				}
				
				$skills_data[$j] = $temp_data;
				$names{$j} = $skills{$j}->choice;

			}
				
			$academic_years = array();
			$val = 0;
			for($i = $from; $i <= $to; $i++){
				$academic_years{$val} = $i;
				$val++;
			}

			return View::make('analytics.skills')
						->with('academic_years', $academic_years)
						->with('skills_data', $skills_data)
						->with('names', $names);
		}

		// return 1;
	}

	public function getEmployability(){
		$course = Course::all();
		$dept = Department::all();

		return View::make('analytics.employability')
					->with('course', $course)
					->with('department', $dept);
	}

	public function getNotEmployed($dept, $from, $to){
		$categories = array();
		$series = array();
		$choices = DB::select('SELECT * FROM survey_choices WHERE question_id = ?', array(6));
		$names = array();

		if($dept == 0){
			foreach($choices as $choice){
				$temp_data = array();
				for($j = $from; $j <= $to; $j++){
					$sql = "SELECT COUNT(tr.choice_id) AS count
							FROM alumni_tracer AS tr
							INNER JOIN alumni AS al
							ON al.id = tr.alumni_id
							WHERE al.year_graduated = ? AND tr.question_id AND tr.choice_id = ?";

					$result = DB::select($sql, array($j, $choice->id));

					if($result == null or $result{0}->count == 0){
						array_push($temp_data, 0);
					} else{
						array_push($temp_data, $result{0}->count);
					}

				}
				array_push($series, $temp_data);
			}
		} else{
			foreach($choices as $choice){
				$temp_data = array();
				for($j = $from; $j <= $to; $j++){
					$sql = "SELECT COUNT(tr.choice_id) AS count
							FROM alumni_tracer AS tr
							INNER JOIN alumni AS al
							ON al.id = tr.alumni_id
							INNER JOIN course AS crs
							ON crs.id = al.course_id
							INNER JOIN departments AS dept
							ON dept.id = crs.dept_id
							WHERE al.year_graduated = ? AND tr.question_id AND tr.choice_id = ? AND dept.id = ?";

					$result = DB::select($sql, array($j, $choice->id, $dept));

					if($result == null or $result{0}->count == 0){
						array_push($temp_data, 0);
					} else{
						array_push($temp_data, $result{0}->count);
					}

				}
				array_push($series, $temp_data);
			}
		}

		foreach($choices as $choice){
			array_push($names, $choice->choice);
		}

		for ($i=$from; $i <= $to ; $i++) { 
			array_push($categories, $i);
		}

		return View::make('analytics.reasons_not_employed')
					->with('categories', $categories)
					->with('series', $series)
					->with('names', $names);
	}

	public function getSummaryEmploymentStatus(){
		// $test = $_GET['test'];
		// if($test == 1)
		// 	return '1';
		// else
		// 	return '2';
		$academic_years = array();
		$data = array();
		$program = array();
		

		$from = $_GET['from'];
		$to = $_GET['to'];
		$department = $_GET['department'];
		$emp_status = $_GET['emp_status'];

		$acad_in = 0;
		for ($i=$from; $i <= $to; $i++) { 
			$academic_years{$acad_in} = $i;
			$acad_in++;
		}

		if($department == 0){
			$courses = Course::all();
			$i = 0;
			foreach ($courses as $crs) {
				$crs_id = $crs->id; 
				$temp_data = array();
				$index = 0;

				for ($j=$from; $j <= $to; $j++) { 
					
					$sql = "SELECT tr.choice_id, COUNT(tr.choice_id) AS 'count'
							FROM alumni_tracer AS tr
							INNER JOIN alumni AS al
							ON al.id = tr.alumni_id
							WHERE al.year_graduated = ? 
							AND tr.choice_id = ? 
							AND al.course_id = ?";

					$result = DB::select($sql, array($j, $emp_status, $crs_id));

					if($result{0}->choice_id == null){
						$temp_data{$index} = 0;
					} else{
						$temp_data{$index} = $result{0}->count;
					}
					$index++;
				}
				$program{$i} = $crs->code;
				$data{$i} = $temp_data;
				$i++;
			}
		} else{
			$courses = DB::select("SELECT * FROM course WHERE dept_id = ?", array($department));
			$i = 0;
			foreach ($courses as $crs) {
				$crs_id = $crs->id; 
				$temp_data = array();
				$index = 0;

				for ($j=$from; $j <= $to; $j++) { 
					
					$sql = "SELECT tr.choice_id, COUNT(tr.choice_id) AS 'count'
							FROM alumni_tracer AS tr
							INNER JOIN alumni AS al
							ON al.id = tr.alumni_id
							WHERE al.year_graduated = ? 
							AND tr.choice_id = ? 
							AND al.course_id = ?";

					$result = DB::select($sql, array($j, $emp_status, $crs_id));

					if($result{0}->choice_id == null){
						$temp_data{$index} = 0;
					} else{
						$temp_data{$index} = $result{0}->count;
					}
					$index++;
				}
				$program{$i} = $crs->code;
				$data{$i} = $temp_data;
				$i++;
			}
		}


		return View::make('analytics.summary_employment')
					->with('academic_years', $academic_years)
					->with('program', $program)
					->with('data', $data);
		// return json_encode($academic_years);
	}

	public function getFieldSpecialization($from, $to){
		$values = array();
		$categories = array();

		$employed = array();
		$not_employed = array();
		$never_employed = array();

		$course = DB::select("SELECT id, code FROM course");

		for ($i=0; $i < count($course); $i++) { 
			$sql = "SELECT al.course_id, cr.title, COUNT(al.course_id) AS 'count'
					FROM course AS cr
					INNER JOIN alumni AS al
					ON al.course_id = cr.id
					WHERE cr.id = ? AND al.year_graduated BETWEEN ? AND ?
					GROUP BY al.course_id";
			$sql2 = "SELECT tr.choice_id, COUNT(tr.choice_id) AS 'count'
					FROM alumni_tracer AS tr
					INNER JOIN alumni AS al
					ON al.id = tr.alumni_id
					WHERE tr.question_id = 5 AND al.course_id = ? AND tr.choice_id = 36 
					AND al.year_graduated BETWEEN ? AND ?
					GROUP BY tr.choice_id";
			$sql3 = "SELECT tr.choice_id, COUNT(tr.choice_id) AS 'count'
					FROM alumni_tracer AS tr
					INNER JOIN alumni AS al
					ON al.id = tr.alumni_id
					WHERE tr.question_id = 5 AND al.course_id = ? AND tr.choice_id = 37
					AND al.year_graduated BETWEEN ? AND ?
					GROUP BY tr.choice_id";
			$sql4 = "SELECT tr.choice_id, COUNT(tr.choice_id) AS 'count'
					FROM alumni_tracer AS tr
					INNER JOIN alumni AS al
					ON al.id = tr.alumni_id
					WHERE tr.question_id = 5 AND al.course_id = ? AND tr.choice_id = 38 
					AND al.year_graduated BETWEEN ? AND ?
					GROUP BY tr.choice_id";

			$result = DB::select($sql, array($course{$i}->id, $from, $to));
			$result2 = DB::select($sql2, array($course{$i}->id, $from, $to));
			$result3 = DB::select($sql3, array($course{$i}->id, $from, $to));
			$result4 = DB::select($sql4, array($course{$i}->id, $from, $to));

			if($result == null){
				$values{$i} = 0;
				$categories{$i} = $course{$i}->code;
			} else{
				$values{$i} = $result{0}->count;
				$categories{$i} = $course{$i}->code;
			}

			if($result2 == null){
				$employed{$i} = 0;
			} else{
				$employed{$i} = $result2{0}->count;
			}

			if($result3 == null){
				$not_employed{$i} = 0;
			} else{
				$not_employed{$i} = $result3{0}->count;
			}

			if($result4 == null){
				$never_employed{$i} = 0;
			} else{
				$never_employed{$i} = $result4{0}->count;
			}
		}

		return View::make('analytics.field_specialization')
					->with('values', $values)
					->with('categories', $categories)
					->with('employed', $employed)
					->with('not_employed', $not_employed)
					->with('never_employed', $never_employed);
	}

	public function getEmploymentStatus($filter_course){
		// $filter_course = null;
		$employment_status = null;
		$choices = null;
		$data = array();
		$categories = array();
		$title = '';

		// if(isset($_REQUEST['filter_course'])){
		// 	$filter_course = $_REQUEST['filter_course'];
		// }

		if($filter_course == 0){
			$sql = "SELECT tr.choice_id, ch.choice, COUNT(tr.choice_id) AS 'count'
					FROM alumni_tracer AS tr
					INNER JOIN survey_choices AS ch
					ON tr.choice_id = ch.id
					WHERE tr.question_id = 7
					GROUP BY tr.choice_id";
			$sql2 = "SELECT id, choice FROM survey_choices WHERE question_id = ?";

			$choices = DB::select($sql2, array(7));
			$employment_status = DB::select($sql);
		} else{
			$sql = "SELECT tr.choice_id, ch.choice, COUNT(tr.choice_id) AS 'count'
					FROM alumni AS al
					INNER JOIN alumni_tracer AS tr
					ON tr.alumni_id = al.id
					INNER JOIN survey_choices AS ch
					ON ch.id = tr.choice_id
					WHERE tr.question_id = 7 AND al.course_id = ?
					GROUP BY tr.choice_id";
			$sql2 = "SELECT id, choice FROM survey_choices WHERE question_id = ?";

			$choices = DB::select($sql2, array(7));
			$employment_status = DB::select($sql, array($filter_course));
		}

		// for ($i=0; $i < count($employment_status); $i++) { 
		// 	$data{$i} = $employment_status{$i}->count;
		// 	$categories{$i} = $employment_status{$i}->choice;
		// }

		// for ($i=0; $i < count($choices); $i++) { 
		// 	if($employment_status != null){
		// 		if($employment_status{$i}->choice_id == $choices{$i}->id){
		// 			$data{$i} = $employment_status{$i}->count;
		// 			$categories{$i} = $employment_status{$i}->choice;
		// 		}
		// 	} else{
		// 		$data{$i} = 0;
		// 		$categories{$i} = $choices{$i}->choice;
		// 	}
		// }
		
		if($filter_course == 0){
			$ans = DB::select($sql);

			for ($i=0; $i < count($ans); $i++) {
				$data{$i} = $ans{$i}->count;
				$categories{$i} = $ans{$i}->choice;
			}
			$title = 'All Program';
		} else {
			for ($i=0; $i < count($choices); $i++) { 
				$sql3 = "SELECT tr.choice_id, ch.choice AS 'choice',COUNT(tr.choice_id) AS 'count'
						FROM alumni_tracer AS tr
						INNER JOIN alumni AS al
						ON al.id = tr.alumni_id
						INNER JOIN survey_choices AS ch
						ON tr.choice_id = ch.id
						WHERE tr.choice_id = ? AND al.course_id = ?";
				$an = DB::select($sql3, array($choices{$i}->id, $filter_course));
				$data{$i} = $an{0}->count;
				$categories{$i} = $choices{$i}->choice;
			}
			$t = Course::find($filter_course);
			$title = $t->title;
		}
			
		return View::make('analytics.employment_status')
					->with('employment_status', $employment_status)
					->with('choices', $choices)
					->with('data', $data)
					->with('categories', $categories)
					->with('title', $title);
	}
}