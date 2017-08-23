<?php
	require_once './include/info.function.php';
	function get_book($user_id)
	{
		global $db;
		$book = $db->select("book_info",
			['id','user_id','name','pic_url','old_price','now_price','author','publisher','quality','add_time','ISBN','num','remark'],
			["ORDER" =>  ["add_time" => "DESC"],	//查询5条
			"LIMIT" => [0,5]
		]);
		foreach ($book as &$book_)
		{
			$book_['seller_sex'] = $db->get("user_info","sex",["user_id" => $book_['user_id']]);
			$book_['seller_name'] = $db->get("user_info","nick_name",['id'=> $book_['user_id']]);
		}
		unset($book_);
		$res['book'] = $book;
		return $res;
	}
	function search_book($query)
	{
		global $db;
		$book = $db->select("book_info",['id','user_id','name','pic_url','old_price','now_price','author','publisher','quality','add_time','ISBN','num','remark'],[
			"OR"=>[
				'name[~]'=>$query,
				'author[~]'=>$query,
				'ISBN[~]'=>$query
				],
			"ORDER" =>  ["add_time" => "ASC"],	//查询10条
			"LIMIT" => [0,5]
			]);
		foreach ($book as &$book_)
		{
			$book_['seller_sex'] = $db->get("user_info","sex",["user_id" => $book_['user_id']]);
			$book_['seller_name'] = $db->get("user","user_name",['id'=> $book_['user_id']]);
		}
		unset($book_);
		return $book;
	}
	function add_book($uid,$ISBN,$name,$author,$publisher,$old_price,$now_price,$num,$classify,$quality,$remark,$pic_url)
	{
		global $db;
		switch ($quality) {
			case '全新':
				$quality = 5;
				break;
			case '9成新':
				$quality = 4;
				break;
			case '8成新':
				$quality = 3;
				break;
			case '7成新':
				$quality = 2;
				break;
			case '6成新':
				$quality = 1;
				break;
			default:
				$quality = 0;
				break;
		}
		switch ($classify) {
			case '文学艺术':
				$classify = 9;
				break;
			case '人文社科':
				$classify = 8;
				break;
			case '经济管理':
				$classify = 7;
				break;
			case '生活休闲':
				$classify = 6;
				break;
			case '外语学习':
				$classify = 5;
				break;
			case '自然科学':
				$classify = 4;
				break;
			case '考试教育':
				$classify = 3;
				break;
			case '计算机':
				$classify = 2;
				break;
			case '医学':
				$classify = 1;
				break;
			default:
				$classify = 0;
				break;
		}
		$res = $db->insert("book_info",[

			"user_id"	=>	$uid,
			"name"	=>	$name,
			"old_price"	=>	$old_price,
			"now_price"	=>	$now_price,
			"author"	=>	$author,
			"publisher"	=>	$publisher,
			"quality"	=>	$quality,
			"add_time"	=>	time(),
			"ISBN"	=>	$ISBN,
			"num"	=>	$num,
			"classify"	=>	$classify,
			"remark"	=>	$remark,
			"pic_url"	=>	$pic_url
			]);
		$db->update("user_info",[
			"sell_num[+]"=>1
			],["user_id"=>$uid]);
			var_dump($uid);
			var_dump($res);
		if($res)
			return 1;
		else
			return 0;
	}