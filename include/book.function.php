<?php
	require_once './include/info.function.php';
	function get_book($user_id)
	{
		global $db;
		$book = $db->select("book_info",
			['id','user_id','name','pic_url','old_price','now_price','author','publisher','quality','add_time','ISBN','num','remark'],
			["ORDER" =>  ["add_time" => "ASC"],	//查询5条
			"LIMIT" => [0,5]
		]);
		foreach ($book as &$book_)
		{
			$book_['seller_sex'] = $db->get("user_info","sex",["user_id" => $book_['user_id']]);
			$book_['seller_name'] = $db->get("user","user_name",['id'=> $book_['user_id']]);
		}
		unset($book_);
		$res['book'] = $book;
		return $res;
	}
