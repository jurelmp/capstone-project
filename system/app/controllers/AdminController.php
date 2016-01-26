<?php

class AdminController extends BaseController{

	public function __construct(){
		$this->beforeFilter('admin');
	}

	public function getIndex(){
		$sql = "SELECT * FROM accounts";
		$users = DB::select($sql);

		return View::make('admin.index')
			->with('users', $users);
	}

	public function getAlumniPending(){
		return View::make('admin.list_pending');
	}
	public function getAlumniConfirm(){
		return View::make('admin.list_confirm');
	}

	public function getJobCategories(){
		$job_categories = JobCategory::all();
		return View::make('admin.job_categories')
					->with('job_categories', $job_categories);
	}
	public function getViewCategory($id){
		$jobs = Job::where('category_id', '=', $id)->get();
		return View::make('admin.view_category')
					->with('jobs', $jobs);
	}
	public function postAddCategory(){
		$category = new JobCategory;
		$category->category = $_POST['name'];
		$category->save();
		return 1;
	}
	public function postAddJob(){
		$job = new Job;
		$job->job = $_POST['name'];
		$job->category_id = $_POST['cat_id'];
		$job->save();
	}

	public function postSendSurvey(){
		try {
			$mail_to = $_POST['mail_to'];
			$subject = $_POST['subject'];
			$msg = $_POST['message'];

			Mail::send('emails.survey_form', array('msg' => $msg), function($message){
				// $email = $_POST['mail_to'];
				// $subject = $_POST['subject'];
				// $msg = $_POST['message'];
				$path_file = URL::to('uploaded_files/sample_survey.pdf');
				// $message->attach($path_file);
				// $message->to($email, $email)->subject($subject);

				// $file = Config::get('uploaded_files') . '/sample_survey.pdf';
				$message->attach($path_file, array('as' => 'Tracer Survey Form', 'mime' => 'application/pdf'));

				$message->to($_POST['mail_to'])->subject($_POST['subject']);
			});

			return 1;
		} catch (Exception $e) {
			return $e;
		}
	}

	public function getCompanyList(){
		$companies = Company::all();
		return View::make('admin.list_company')
					->with('companies', $companies);
	}
	public function getViewCompany($company_id){
		$sql = "SELECT al.*, wrk.date_hired, wrk.date_finished, occ.title
				FROM alumni AS al
				INNER JOIN work_experience AS wrk
				ON wrk.alumni_id = al.id
				INNER JOIN company AS com
				ON com.id = wrk.company_id
				INNER JOIN occupation AS occ
				ON occ.id = wrk.occupation_id
				WHERE com.id = ?";

		$company = Company::find($company_id);
		$employees = DB::select($sql, array($company_id));
		return View::make('admin.view_company')
					->with('company', $company)
					->with('employees', $employees);
	}

	public function postSendMail(){
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$msg = $_POST['message'];

		Mail::send('emails.send_email', array('msg' => $msg), function($message){
			$email = $_POST['email'];
			$subject = $_POST['subject'];
			$msg = $_POST['message'];

			$message->to($email, $email)->subject($subject);
		});

		return 0;
	}

	public function postDeleteMessage(){
		$sql = "DELETE FROM messages WHERE id = ?";

		$msg_id = $_POST['msg_id'];

		$result = DB::delete($sql, array($msg_id));

		return $result;
	}

	public function getMessages(){
		$sql = "SELECT msg.*, CONCAT(acc.firstname, ' ', acc.lastname) AS 'fullname', acc.email
				FROM messages AS msg
				INNER JOIN accounts AS acc
				ON acc.id = msg.account_id
				ORDER BY msg.created_at DESC";

		$messages = DB::select($sql);

		foreach ($messages as $message) {
			$message->created_at = date('g:i A \o\n F d Y, l', strtotime($message->created_at));
		}

		return View::make('admin.messages')
				->with('messages', $messages);
	}

	public function postMarkAsRead(){
		$sql = "UPDATE messages SET is_new = 0
				WHERE id = ?";

		$msg_id = $_POST['id'];

		$updated = DB::update($sql, array($msg_id));
		return $updated;
	}

	public function postViewMessage(){
		$sql = "SELECT msg.*, CONCAT(acc.firstname, ' ', acc.lastname) AS 'fullname'
				FROM messages AS msg
				INNER JOIN accounts AS acc
				ON acc.id = msg.account_id
				WHERE msg.id = ?";

		$msg_id = $_POST['id'];

		$message = DB::select($sql, array($msg_id));
		$message{0}->created_at = date('g:i A \o\n F d Y, l', strtotime($message{0}->created_at));

		return json_encode($message);
	}

	public function getMasterList(){
		$sql = "SELECT sm.*, cr.id AS course_id, cr.code AS course
				FROM student_master AS sm 
				INNER JOIN course AS cr
				ON sm.course_id = cr.id
				ORDER BY last_name ASC";
		$master = DB::select($sql);

		$course = Course::all();

		return View::make('admin.master_list')
					->with('master', $master)
					->with('course', $course);
	}

	public function postMasterTable(){
		// $filter = $_REQUEST['filter'];

		if(isset($_REQUEST['filter'])){
			$sql = "SELECT * FROM csv_test";
			$test = DB::select($sql);
			return View::make('admin.table_master_list')
						->with('test', $test);
		}
	}

	public function postDeleteSingleMaster(){
		$id = $_POST['id'];
		$r = DB::delete("DELETE FROM student_master WHERE id = ?", array($id));
		return $r;
	}

	public function postSaveSingleMaster(){

		try {
			$studno = $_POST['studno'];
			$lname = $_POST['lname'];
			$fname = $_POST['fname'];
			$mname = $_POST['mname'];
			$course = $_POST['course'];
			$batch = $_POST['batch'];

			$sql = "INSERT INTO student_master (stud_no, last_name, first_name, mid_name, course_id, batch) VALUES(?, ?, ?, ?, ?, ?)";

			DB::insert($sql, array($studno, $lname, $fname, $mname, $course, $batch));

			return 0;
		} catch (Exception $e) {
			return $e;
		}

		
	}

	public function postImportFile(){
		if(!Input::hasFile('upload')){
			return 0;
		} else {
			$file = Input::file('upload');
			$results = null;

			$orig_name = $file->getClientOriginalName();
			$destination = 'uploaded_files/';

			$success = $file->move(public_path($destination), $orig_name);

			$new = URL::to($destination . $orig_name);

			// Excel::selectSheetsByIndex(0)->load($new, function($reader){
				// $results = $reader->toArray();
				// $results = $reader->select(array('ID_NO', 'FAMILY_NAME', 'FIRST_NAME', 'M', 'COURSE', 'YEAR'))->get();
			// });
			return $new;
		}
	}

	public function postSaveImportCsv(){

		try {
			$csv = $_REQUEST['data'];

			for ($i=1; $i < count($csv); $i++) { 
				$sql = "INSERT INTO student_master (stud_no, last_name, first_name, mid_name, course_id, batch) VALUES(?, ?, ?, ?, ?, ?)";

				if($csv[$i][0] != '' && $csv[$i][4] != ''){
					$crs = DB::select("SELECT * FROM course WHERE code = ?", array($csv[$i][4]));
					$c_id = $crs{0}->id;
					DB::insert($sql, array($csv[$i][0], $csv[$i][1], $csv[$i][2], $csv[$i][3], $c_id, $csv[$i][5],));
				} else{
					break;
				}
			}
			return 1;	
		} catch (Exception $e) {
			return $e;
		}
		
	}

	public function getProfile($id){
		$sql = "SELECT al.*, re.name AS region, pr.name AS province, cr.title AS course, cr.code
				FROM alumni AS al
				INNER JOIN regions AS re
				ON al.region_id = re.id
				INNER JOIN provinces AS pr
				ON al.province_id = pr.id
				INNER JOIN course AS cr
				ON al.course_id = cr.id
				WHERE al.id = ?";
		$sql2 = "SELECT de.id, de.program, de.year_graduated, de.awards, dt.value AS title, sc.id AS school_id, sc.name AS school_name
				FROM degree AS de
				INNER JOIN degree_title AS dt
				ON de.deg_title_id = dt.id
				INNER JOIN school AS sc
				ON de.school_id = sc.id
				WHERE de.alumni_id = ?";
		$sql3 = "SELECT id, title, rating, date_taken
				FROM certificate WHERE alumni_id = ?";
		$sql4 = "SELECT we.id, we.date_hired, we.date_finished, we.place_of_work, com.name, occ.title
				FROM work_experience AS we
				INNER JOIN company AS com
				ON we.company_id = com.id
				INNER JOIN occupation AS occ
				ON we.occupation_id = occ.id
				WHERE alumni_id = ?";
		$sql5 = "SELECT tr.*, sq.*, ch.*
				FROM alumni_tracer AS tr
				INNER JOIN alumni aS al
				ON al.id = tr.alumni_id
				INNER JOIN survey_questions AS sq
				ON sq.id = tr.question_id
				INNER JOIN survey_choices AS ch
				ON ch.id = tr.choice_id
				WHERE al.id = ?";

		$info = DB::select($sql, array($id));
		$degree = DB::select($sql2, array($id));
		$exam = DB::select($sql3, array($id));
		$work = DB::select($sql4, array($id));
		$survey = DB::select($sql5, array($id));

		return View::make('admin.view_alumni')
					->with('info', $info)
					->with('degree', $degree)
					->with('exam', $exam)
					->with('work', $work)
					->with('survey', $survey);
	}

	public function getSurvey(){
		// $sql = "SELECT sq.*, ch.*
		// 		FROM survey_questions AS sq
		// 		INNER JOIN survey_choices AS ch
		// 		ON ch.question_id = sq.id";
		$sql = "SELECT * FROM survey_questions";

		$questions = DB::select($sql);

		return View::make('admin.manage_survey')
					->with('questions', $questions);
	}

	public function getRecords(){
		// $sql = "SELECT * FROM alumni";
		$sql = "SELECT a.*, c.code, acc.email
				FROM alumni AS a
				INNER JOIN course AS c
				ON a.course_id = c.id
				INNER JOIN accounts AS acc
				ON a.account_id = acc.id
				ORDER BY a.id ASC";

		$alumni = DB::select($sql);

		return View::make('admin.list_alumni')
				->with('alumni', $alumni);
	}

	public function postVerifyAlumni(){
		$sql = "UPDATE alumni SET is_confirmed = 1 WHERE id = ?";
		$alumni_id = $_POST['alumni_id'];
		return DB::update($sql, array($alumni_id));
	}
	public function postUnverifyAlumni(){
		$sql = "UPDATE alumni SET is_confirmed = 0 WHERE id = ?";
		$alumni_id = $_POST['alumni_id'];
		return DB::update($sql, array($alumni_id));
	}

	public function getAnalytics(){
		return View::make('admin.analytic');
	}

	// public function getMaster(){
	// 	return View::make('admin.view_master');
	// }

	public function getCourses(){
		$sql = "SELECT d.name, c.id, c.title, c.description, c.code
				FROM course AS c
				INNER JOIN departments AS d
				ON c.dept_id = d.id
				ORDER BY d.name";
		$sql2 = "SELECT id, name FROM departments";

		$crs = DB::select($sql);
		$dept = DB::select($sql2);

		return View::make('admin.list_course')
				->with('course', $crs)
				->with('department', $dept);
	}

	public function postCoursenew(){
		$sql = "INSERT INTO course (title, description, code, dept_id) VALUES (?, ?, ?, ?)";

		$title = $_POST['title'];
		$dept = $_POST['dept'];
		$desc = $_POST['desc'];
		$code = $_POST['prog_code'];
		// $cde = $_POST['pcode'];
		$cde = '';

		$s = DB::insert($sql, array($title, $desc, $code, $dept));

		return 1;
	}


	// ===========================department management module==================================
	public function getListDepartments(){
		$departments = Department::all();
		return View::make('admin.departments')
					->with('departments', $departments); 
	}
	public function getViewDepartment($id){
		$sql = "SELECT * FROM departments WHERE id = ?";
		$d = DB::select($sql, array($id));
		return json_encode($d);
	}
	public function getDepartment($id){
		$sql = "SELECT * FROM departments WHERE id = ?";
		$department = DB::select($sql, array($id));
		$programs = Course::where('dept_id', '=', $id)->get();
		$job_categories = JobCategory::all();
		return View::make('admin.department')
					->with('department', $department)
					->with('programs', $programs)
					->with('job_categories', $job_categories);
	}
	public function getProgram($id){
		$program = Course::where('id', '=', $id)->get();
		return json_encode($program);
	}
	public function postAddJobDescription(){
		$jd = new JobDescription;
		$jd->course_id = $_POST['course_id'];
		$jd->job_id = $_POST['job_id'];

		if($jd->save()){
			return 1;
		} else{
			return 0;
		}
	}
	public function getJobsByCategory($id){
		$jobs = Job::where('category_id', '=', $id)->get();
		return json_encode($jobs);
	}
	public function getProgramJobDescriptions($id){
		$sql = "SELECT jd.id, jd.job_id AS 'job_id', j.job
				FROM job_description AS jd
				INNER JOIN jobs AS j
				ON j.id = jd.job_id
				INNER JOIN course AS crs
				ON crs.id = jd.course_id
				WHERE crs.id = ?";
		$job_desc = DB::select($sql, array($id));

		return json_encode($job_desc);
	}
	public function postAddProgram(){
		$program = new Course;
		$program->title = $_POST['code'];
		$program->code = $_POST['title'];
		$program->dept_id = $_POST['dept_id'];

		if($program->save()){
			return "success";
		} else{
			return "fail";
		}
	}
	public function postUpdateProgram(){
		$id = $_POST['id'];
		$code = $_POST['code'];
		$title = $_POST['title'];
		$program = Course::find($id);
		$program->code = $code;
		$program->title = $title;

		if($program->save()){
			return "success";
		} else{
			return "fail";
		}
	}


	public function getDepartments(){
		$sql = "SELECT d.id, d.name, d.description, d.code, COUNT(c.id) AS courses
				FROM course AS c
				RIGHT JOIN departments AS d
				ON d.id = c.dept_id
				GROUP BY d.name
				ORDER BY d.id";

		$list_dept = DB::select($sql);

		return View::make('admin.list_departments')
				->with('departments', $list_dept);
	}

	public function postDeptcourse(){
		$id = $_POST['dept_id'];

		// $sql = "SELECT * FROM course WHERE dept_id = $id";
		$sql = "SELECT d.name, c.* FROM departments AS d
				LEFT JOIN course AS c
				ON c.dept_id = d.id
				WHERE d.id = $id";

		$list_course = DB::select($sql);

		return json_encode($list_course);
	}

	public function postUpdatedept(){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$code = $_POST['code'];
		$desc = $_POST['desc'];

		$sql = "UPDATE departments SET name = '$name',
										code = '$code',
										description = '$desc'
										WHERE id = ?";

		return DB::update($sql, array($id));
	}

	public function postGetdept(){
		$id = $_POST['id'];
		$sql = "SELECT * FROM departments WHERE id = ?";
		$d = DB::select($sql, array($id));
		return json_encode($d);
	}

	public function postCreatedept(){
		$name = $_POST['name'];
		$desc = $_POST['desc'];
		$code = $_POST['code'];

		// $sql = "INSERT INTO departments(name, code, description)
		// 		VALUES($name, $code, $desc)";

		// DB::insert($sql);

		$dept = new Department;
		$dept->name = $name;
		$dept->description = $desc;
		$dept->code = $code;

		if($dept->save())
			return 'success';
		else
			return 'fail';
	}
	// ===========================end of department management module==================================

	
	// ===========================news management module==================================
	public function getNews(){
		// $sql = "SELECT * FROM news";
		$sql = "SELECT a.firstname, a.lastname, a.midname, n.*
				FROM accounts AS a
				INNER JOIN news AS n
				ON a.id = n.account_id
				ORDER BY n.created_at DESC";

		$news = DB::select($sql);

		return View::make('admin.manage_news')
			->with('news', $news);
	}

	public function getNewsinfo(){
		$n_id = $_GET['id'];

		$sql = "SELECT * FROM news WHERE id = ?";

		$news = DB::select($sql, array($n_id));
		return json_encode($news);
	}

	public function postDeletenews(){
		$del_id = $_POST['del_id'];

		$sql = "DELETE FROM news WHERE id = ?";

		return DB::delete($sql, array($del_id));
	}

	public function postUpdatenews(){
		$id = $_POST['id'];
		$title = $_POST['title'];
		$content = $_POST['content'];
		$update_at = date('Y-m-d H:i:s');

		$sql = "UPDATE news SET title = '$title',
								content = '$content',
								updated_at = '$update_at'
								WHERE id = ?";

		return DB::update($sql, array($id));
	}

	public function getAlumninames(){
		$sql = "SELECT firstname, midname, lastname FROM alumni";
		$n = DB::select($sql);
		// $names = array();
		return json_encode($n);
	}

	// public function getViewnews($id){
	// 	$sql = "SELECT * FROM news
	// 			WHERE id = ?";
	// 	$news = DB::select($sql, array($id));

	// 	return View::make('home.view_news')
	// 		->with('v_news', $news);
	// }

	public function getAccountname(){
		if(Auth::check()){
			$acc = DB::select('SELECT lastname,
									firstname, 
									midname 
								FROM admin 
								WHERE account_id = '. Auth::user()->id);

			if($acc === null){
				return 'null';
			} else {
				return json_encode($acc);
			}
		}
		
	}

	public function postCreatenews(){
		$news = new News;

		$title = $_POST['title'];
		$content = $_POST['content'];
		$acc_id = (int)$_POST['account_id'];

		// $d = date();

		$news->title = $title;
		$news->content = $content;
		$news->account_id = $acc_id;
		// $news->created_at = date('Y-m-d H:i:s');

		if($news->save())
			return 1;
		else
			return 0;		
	}
	// ===========================end of news management module==================================


	// ===========================account management module==================================
	public function postAddaccount(){
		$sql1 = "SELECT username FROM accounts WHERE username = ?";
		$sql2 = "SELECT email FROM accounts WHERE email = ?";

		$chk_user = DB::select($sql1, array($_POST['username']));
		$chk_email  = DB::select($sql2, array($_POST['email']));

		if($chk_user == null && $chk_email == null){
			$user = new User;
			$user->username = $_POST['username'];
			$user->firstname = $_POST['fname'];
			$user->midname = $_POST['mname'];
			$user->lastname = $_POST['lname'];
			$user->password = Hash::make($_POST['password']);
			$user->email = $_POST['email'];
			$user->acc_type = (int)$_POST['acc_type'];


			// if($user->save()){
			// 	return 'success';
			// } else {
			// 	return 'fail';
			// }
			$user->save();

			return 0;
		} elseif($chk_user != null && $chk_email == null) {
			return 3;
		} elseif($chk_email != null && $chk_user == null) {
			return 2;
		} else {
			return 1;
		}
		// return Redirect::to('admin');
		// return URL::to('/admin/index');
	}

	public function postDeactivateAccount(){
		$id = $_POST['id'];
		$sql = "UPDATE accounts SET is_active = 0 WHERE id = ?";
		$r = DB::update($sql, array($id));
		return $r;
	}

	public function postDeleteaccount(){

		$user_id = $_POST['user_id'];

		$user = User::find($user_id);
		
		// if($user->delete()){
		// 	return 'success';
		// } else {
		// 	return 'fail';
		// }
		$user->delete();

		return Redirect::to('admin');
	}

	public function postUpdateaccount(){

		$id = $_POST['id'];
		$user = $_POST['user'];
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];

		$p = $_POST['pass'];
		$pass = Hash::make($_POST['pass']);

		$email = $_POST['email'];
		$acc_type = $_POST['type'];
		$stat = $_POST['stat'];

		$pcheck = Hash::check('password', $p);
		$passcheck = Hash::check('password', $pass);

		if(!$passcheck){
			$sql = "UPDATE accounts SET username = '$user',
										 firstname = '$fname',
										 midname = '$mname',
										 lastname = '$lname',
										 password = '$pass',
										 email = '$email',
										 acc_type = $acc_type,
										 is_active = $stat WHERE id = ?";
		} else {
			$sql = "UPDATE accounts SET username = '$user',
										 firstname = '$fname',
										 midname = '$mname',
										 lastname = '$lname',
										 email = '$email',
										 acc_type = $acc_type,
										 is_active = $stat WHERE id = ?";
		}

		return DB::update($sql, array($id));
		// return Redirect::to('admin');
	}

	public function getAccount($id){

		$sql =  "SELECT * FROM accounts WHERE id = " . $id;
		$account = DB::select($sql);

		return json_encode($account);
		// return View::make('admin.update_account')
		// 	->with('account', $account);
	}
	// ===========================end of account management module==================================
	
}