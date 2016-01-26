<?php

class News extends Eloquent {

	protected $table = 'news';
	
	// protected $fillable = array('title', 'content', 'account_id');

	// public static function insertNews($t, $c, $i){
	// 	$sql = "INSERT INTO news(title, content, account_id) 
	// 			VALUES(?, ?, ?)";
	// 	DB::insert($sql, array($t, $c, $i));
	// 	return 0;
	// }
}