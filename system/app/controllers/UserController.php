<?php

class UserController extends BaseController {

	// public function __construct(){
	// 	$this->beforeFilter('alumni');
	// }

	public function getIndex(){
		return View::make('user.index');
	}

	public function getProfile(){
		return View::make('user.user_profile');
	}

	public function getAccountsetting(){
		$sql = "SELECT * FROM accounts WHERE id = " . Auth::user()->id;
		$account = DB::select($sql);

		return View::make('user.user_settings')
			->with('account', $account);
	}

	public function postVerifyProfile(){
		$studno = $_POST['studno'];

		if($studno == null){
			return 0;
		} else{
			$sql = "SELECT * FROM student_master WHERE stud_no = ?";

			$student = DB::select($sql, array($studno));

			return json_encode($student);
		}	
	}

	public function postSendMessage(){
		$sql = "INSERT INTO messages (account_id, subject, message, created_at) VALUES (?, ?, ?, ?)";

		$subject = $_POST['subject'];
		$message = $_POST['message'];
		$date = date('Y-m-d H:i:s');
		$account_id = Auth::user()->id;

		DB::select($sql, array($account_id, $subject, $message, $date));
		
		return 0;
	}

	public function postUpdatepass(){
		$id = $_POST['id'];
		$pass = Hash::make($_POST['password']);

		$update = date('Y-m-d H:i:s');

		$sql = "UPDATE accounts SET password = '$pass',
									updated_at = '$update'
								WHERE id = ?";
		return DB::update($sql, array($id));
	}

	public function postCheckpassword(){
		$pass = $_POST['pass'];

		if(Hash::check($pass, Auth::user()->password)){
			return "success";
		} else {
			return "fail";
		}
	}


	public function getMyprofile(){
		$id = Auth::user()->id;
		$alumni_id = null;

		$sql = "SELECT * FROM alumni WHERE account_id = ?";
		$prof = DB::select($sql, array($id));

		if($prof != null)
			$alumni_id = $prof{0}->id;

		$sql2 = "SELECT * FROM degree WHERE alumni_id = ?";
		$deg = DB::select($sql2, array($alumni_id));

		$sql3 = "SELECT * FROM work_experience WHERE alumni_id = ?";
		$wrk_exp = DB::select($sql3, array($alumni_id));

		$sql4 = "SELECT * FROM certificate WHERE alumni_id = ?";
		$certificate = DB::select($sql4, array($alumni_id));

		// $sql5 = "SELECT * FROM alumni_tracer WHERE alumni_id = ?";
		$sql5 = "SELECT at.*, sq.question, sc.choice
				FROM alumni_tracer AS at
				INNER JOIN survey_questions AS sq
				ON sq.id = at.question_id
				INNER JOIN survey_choices AS sc
				ON sc.id = at.choice_id
				WHERE at.alumni_id = ?
				ORDER BY at.question_id";

		$a_tracer = DB::select($sql5, array($alumni_id));

		$dept = Department::all();
		$region = Region::all();
		$province = Province::all();
		$occupation = Occupation::all();
		$company = Company::all();
		$deg_title = DegreeTitle::all();
		$school = School::all();
		$jobs = Job::all();
		$field = Field::all();
		$questions = DB::select("SELECT * FROM survey_questions");
		$civil_status = DB::select("SELECT * FROM civil_status");

		return View::make('user.profile')
				->with('company', $company)
				->with('field', $field)
				->with('occupation', $occupation)
				->with('work_exp', $wrk_exp)
				->with('degree', $deg)
				->with('a_tracer', $a_tracer)
				->with('certificate', $certificate)
				->with('school', $school)
				->with('deg_title', $deg_title)
				->with('profile', $prof)
				->with('dept', $dept)
				->with('region', $region)
				->with('province', $province)
				->with('civil_status', $civil_status)
				->with('questions', $questions)
				->with('jobs', $jobs);
	}

	public function postUpdateProfile(){
		$id = $_POST['id'];
		$firstname = $_POST['firstname'];
		$midname = $_POST['midname'];
		$lastname = $_POST['lastname'];
		$gender = $_POST['gender'];
		$birthdate = $_POST['birthdate'];
		$civil_stat = $_POST['civil_stat'];
		$email = $_POST['email'];
		$phone_no = $_POST['phone_no'];
		$mobile_no = $_POST['mobile_no'];
		$address = $_POST['address'];

		$sql = "UPDATE alumni SET firstname = ?,
								midname = ?,
								lastname = ?,
								gender = ?,
								birthdate = ?,
								civil_stat = ?,
								email = ?,
								tel_no = ?,
								mobile_no = ?,
								address = ?
				WHERE id = ?";
		$up = DB::update($sql, array($firstname, $midname, $lastname,
									$gender, $birthdate, $civil_stat, $email,
									$phone_no, $mobile_no, $address, $id));

		return $up;
	}

	public function postSurveysubmit(){
		$data = $_REQUEST['data'];

		for($i = 0;$i < count($data);$i++){
			$al_id = null;
			$qu_id = null;
			$ch_id = null;
			$ans = null;

			if($data[$i]['alumni_id'] != ''){
				$al_id = $data[$i]['alumni_id'];
			}
			if($data[$i]['question_id'] != ''){
				$qu_id = $data[$i]['question_id'];
			}
			if($data[$i]['choice_id'] != ''){
				$ch_id = $data[$i]['choice_id'];
			}
			if($data[$i]['answer'] != ''){
				$ans = $data[$i]['answer'];
			}

			$sql = "INSERT INTO alumni_tracer (alumni_id, question_id, choice_id, answer) VALUES (?, ?, ?, ?)";
			DB::insert($sql, array((int)$al_id, (int)$qu_id, (int)$ch_id, $ans));
		}

		return count($data);
	}

	public function postCertificatenew(){
		$acc_id = Auth::user()->id;
		// $al_id = null;

		$al_id = DB::select("SELECT id FROM alumni 
							WHERE account_id = ?", array($acc_id));

		$name = $_POST['name'];
		$desc = $_POST['desc'];
		$date_taken = $_POST['date_taken'];
		$rating = $_POST['rating'];

		$sql = "INSERT INTO certificate(title, description, rating, date_taken, alumni_id)
				VALUES(?, ?, ?, ?, ?)";

		$c_add = DB::insert($sql, array($name, $desc, $rating, $date_taken, $al_id{0}->id));

		return 0;
	}


	public function postWorkexpadd(){
		$a_i = DB::select("SELECT id FROM alumni WHERE account_id = ?", array(Auth::user()->id));
		$al_id = $a_i{0}->id;

		$company = $_POST['company'];
		$occupation = $_POST['occupation'];
		$place = $_POST['place'];
		$date_hired = date('Y-m-d', strtotime($_POST['date_hired']));

		$d_f = $_POST['date_finished'];

		if($d_f == null)
			$date_finished = null;
		else
			$date_finished = date('Y-m-d', strtotime($d_f));

		$sql = "INSERT INTO work_experience(alumni_id, company_id, occupation_id, date_hired, date_finished, place_of_work)
				VALUES(?, ?, ?, ?, ?, ?)";

		$w_e = DB::insert($sql, array($al_id, $company, $occupation, $date_hired, $date_finished, $place));

		return 0;
	}

	public function postCompanyadd(){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$tel_no = $_POST['tel_no'];
		$mobile_no = $_POST['mobile_no'];
		$field = $_POST['field'];
		$date = date('Y-m-d H:i:s');

		$sql = "INSERT INTO company(name, email, address, tel_no,
									mobile_no, field_id, created_at, updated_at)
							VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

		$comp = DB::insert($sql, array($name, $email, $address, $tel_no, $mobile_no
			, $field, $date, $date));

		$sql_select = "SELECT * FROM company ORDER BY id DESC";

		return json_encode(DB::select($sql_select));
	}

	public function postSchooladd(){
		// $school = School::all();
		$school_name = $_POST['sch_name'];
		$sql = "INSERT INTO school (name) VALUES(?)";
		$s = DB::insert($sql, array($school_name));
		$school = DB::select("SELECT * FROM school ORDER BY id DESC");
		return json_encode($school);
	}

	public function postDegreeadd(){
		$program = $_POST['program'];
		$title = $_POST['title'];
		$year = $_POST['year'];
		$school = $_POST['school'];
		$award = $_POST['award'];

		$a_id = DB::select("SELECT id FROM alumni WHERE account_id = ?", array(Auth::user()->id));

		$sql = "INSERT INTO degree (program, deg_title_id, year_graduated, school_id, awards, alumni_id)
						 VALUES (?, ?, ?, ?, ?, ?)";

		$s = DB::insert($sql, array($program, (int)$title, $year, (int)$school, $award, (int)$a_id{0}->id));
		return 0;
	}

	public function postBasicinfo(){
		$account_id = Auth::user()->id;
		// $img = $_FILES['image']['files'];
		$img = $_POST['image'];
		$studno = $_POST['studno'];
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$lname = $_POST['lname'];
		$gender = $_POST['gender'];
		$birthdate = $_POST['birthdate'];
		$civil_stat = $_POST['civil_stat'];
		$tel_no = $_POST['phone_no'];
		$mobile_no = $_POST['mobile_no'];
		$region = $_POST['region'];
		$province = $_POST['province'];
		$address = $_POST['address'];
		// $department = $_POST['department'];
		$course = $_POST['course'];
		$term = $_POST['term'];
		$year = $_POST['year'];

		// $image = Input::file('image');
		// $filename = date('Y-m-d H:i:s')."-".$image->getClientOriginalName();
		// $folder_path = '../images/uploaded_images/alumni/';
		// Image::make($image)->resize(468, 249)->save($folder_path.$filename);
		// $pic_path = $folder_path.$filename;

		$date = date('Y-m-d H:i:s');

		$sql = "INSERT INTO alumni (stud_no, lastname, firstname, midname,
									gender, civil_stat, birthdate, address,
									tel_no, mobile_no, pic_path, region_id,
									province_id, course_id, term, year_graduated,
									account_id, created_at, updated_at)
						VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		
		DB::insert($sql, array($studno, $lname, $fname, $mname, $gender,
								$civil_stat, $birthdate, $address, $tel_no, $mobile_no,
								$img, $region, $province, $course, $term, $year, $account_id,
								$date, $date));

		// return 1;
	}

	public function postUploadphoto(){
		$image = Input::file('img');

		// $filename = date('Y-m-d H:i:s')."-".$image->getClientOriginalName();
		// $folder_path = URL::to('/images/uploaded_images/alumni/');
		// $folder_path = "../images/uploaded_images/alumni/";
		// Image::make($image->getRealPath(), 20)->resize(200, 200)->save($folder_path,$filename, 90);
		// $pic_path = $folder_path.$filename;

		// $destination = URL::to('/images/uploaded_images/alumni');
		// $destination = '../images/';
		// $upsuccess = Input::file('image')->move($destination, $filename);

		if(!Input::hasFile('img')){
			return 0;
		} else {
			// $filename2 = str_random(12).'.jpg';
			// $destination = 'images/uploaded_images/alumni';
			// Image::make($image->getRealPath())->resize('200', '200')->save($destination, $filename2);

			$filename = $image->getClientOriginalName();
			$filename2 = str_random(12).'.jpg';
			$destination = 'images/uploaded_images/alumni/';

			$success = $image->move(public_path($destination), $filename2);
			
			$path = $destination . $filename2;
			return $path;
		}		
	}

	
}