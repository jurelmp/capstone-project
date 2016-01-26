<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getLogin(){

		if(Auth::check())
			return Redirect::to('/');
		else
			return View::make('login.index');
	}

	public function postLogin(){
		$rules = array(
			'username' => 'required|alphaNum|min:4',
			'password' => 'required|alphaNum|min:8'
		);

		$msg = '';
		$k = false;

		$validator = Validator::make(Input::all(), $rules);

		$username = Input::get('username');
		$password = Input::get('password');
		
		if(Input::get('keepme') === 1){
			$keep = true;
		} else {
			$keep = false;
		}

		$k = $keep;

		if($validator->fails()){
			return Redirect::to('login')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			$userdata = array(
				'username' => $username,
				'password' => $password,
				'is_active' => 1
			);

			if(Auth::attempt($userdata, false)){
				return Redirect::to('/alumni/news');
			} else {
				return Redirect::to('login')
					->with('loginmsg', 'Incorrect Password/Username.');
			}
		}
	}

	public function postLogout(){
		if(Auth::check()){
			Auth::logout();
			return Redirect::to('/login')
				->with('logoutmsg', 'Successfully log out.');
		}
		return Redirect::to('/login');
	}

	public function getCreateaccount(){

		return View::make('register.index');
	}

	public function postCreateaccount(){

		$rules = array(
			'username' => 'required|alphaNum|min:4',
			'password' => 'required|alphaNum|min:8',
			'email' => 'required|email'
		);

		$checker = false;

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()){
			return Redirect::to('register')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			
			$email = Input::get('email');
			$u = Input::get('username');

			$check = DB::select("SELECT email FROM accounts WHERE email = ?", array($email));
			$chk_user = DB::select("SELECT username FROM accounts WHERE username = ?", array($u));

			if(!$check == null || !$chk_user == null){
				$msg = '';
				if($check != null && $chk_user != null){
					$msg = "Email and username already in used.";
					$checker = false;
				} else if($chk_user != null){
					$msg = "Username already exists. Please use another username.";
					$checker = false;
				} else if($check != null){
					$msg = "Email already exists. Please use another email.";
					$checker = true;
				}
				return Redirect::to('register')
					->with('duplicate', $msg)
					->withInput(Input::except('password'));
			} else {

				
				$user = new User;
				$user->username = Input::get('username');
				$user->firstname = ucfirst(strtolower(Input::get('firstname')));
				$user->midname = ucfirst(strtolower(Input::get('midname')));
				$user->lastname = ucfirst(strtolower(Input::get('lastname')));
				$user->email = Input::get('email');
				$user->password = Hash::make(Input::get('password'));
				$user->save();
				
				Mail::send('user.mails.welcome', array('username' => Input::get('username')), function($message){
					$username = Input::get('username');
					$msg = 'Thank you for registering.';
					$message->to(''.Input::get('email').'', $username)->subject($msg);
				});

				// $data = Input::get('username');
				// SMS::send('simple-sms::welcome', Input::get('username'), function(){
				//     $sms->to('+639234275343', 'sun');
				// });

				return Redirect::to('login')
					->with('success', 'Successfully created. You can now login.');
			}
			
		}
	}

	public function getLoginWithFacebook(){
		$code = Input::get('code');

		$fb = OAuth::consumer('Facebook');

		if(!empty($code)){
			$token = $fb->requestAccessToken($code);

			$result = json_decode($fb->request('/me'), true);

			$message = "Your unique facebook user id is : " . $result['id'] . " and your name is " . $result['name'];

			// echo $message . "<br>";
			$info = json_encode($result);

			// echo $info;
			// return $result;

			$user = new User;
			$un = ucfirst(strtolower($result['last_name'] . $result['first_name']));
			$pw = 'alumnidefault';

			$user->username = strtolower($result['last_name'] . $result['first_name']);
			$user->firstname = ucfirst(strtolower($result['first_name']));
			$user->midname = ucfirst(strtolower($result['middle_name']));
			$user->lastname = ucfirst(strtolower($result['last_name']));
			$user->email = strtolower($result['email']);
			$user->password = Hash::make('alumnidefault');
			$user->save();

			$userdata = array(
				'username' => $un,
				'password' => $pw,
				'is_active' => 1
			);

			if(Auth::attempt($userdata, false)){
				return Redirect::to('/');
			} else {
				return Redirect::to('login')
					->with('loginmsg', 'Incorrect Password/Username.');
			}

			// return Redirect::to('/register')->with('result', $result);
		} else{
			$url = $fb->getAuthorizationUri();

			return Redirect::to((string)$url);
		}
	}

}
