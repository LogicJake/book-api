<?php
	require_once './include/info.function.php';
	function get_book($user_id,$type,$page)
	{
		$per_page = 5;		//一页10条数据
    	$start = ($page - 1)*$per_page;
		global $db;
		if ($type == -1) {
			$book = $db->select("book_info",
			['id','user_id','name','pic_url','old_price','now_price','author','publisher','quality','add_time','ISBN','num','remark'],
			["ORDER" =>  ["add_time" => "DESC"],	//查询10条
			"LIMIT" => [$start,$per_page],
			"user_id" => $user_id,
			"status" => 1
			]);
			$num = $db->count("book_info", ["user_id" => $user_id,"status" => 1]);
			$db->update("user_info",[
				"sell_num" => $num
				],["user_id" => $user_id]);
		}
		else {
			if ($type == 0) {
				$book = $db->select("book_info",
				['id','user_id','name','pic_url','old_price','now_price','author','publisher','quality','add_time','ISBN','num','remark'],
				["ORDER" =>  ["add_time" => "DESC"],	//查询10条
				"LIMIT" => [$start,$per_page],
				"status" => 1
				]);
			}
			else{
				$book = $db->select("book_info",
				['id','user_id','name','pic_url','old_price','now_price','author','publisher','quality','add_time','ISBN','num','remark'],
				["ORDER" =>  ["add_time" => "DESC"],	//查询10条
				"LIMIT" => [$start,$per_page],
				"classify" => $type,
				"status" => 1
				]);
			}
		}
		$is_done = false;				//默认没有完成
		if(count($book)<($per_page))//不足个数说明已经返回完毕
        	$is_done = true;
		foreach ($book as &$book_)
		{
			$book_['seller_sex'] = $db->get("user_info","sex",["user_id" => $book_['user_id']]);
			$book_['seller_name'] = $db->get("user_info","nick_name",['id'=> $book_['user_id']]);
		}
		unset($book_);
		$res['book'] = $book;
		$res['is_done'] = $is_done;
		return $res;
	}
	function search_book($query,$page)
	{
		$per_page = 5;		//一页10条数据
    	$start = ($page - 1)*$per_page;
    	$end = $page*$per_page;
		global $db;
		$book = $db->select("book_info",['id','user_id','name','pic_url','old_price','now_price','author','publisher','quality','add_time','ISBN','num','remark'],[
			"OR"=>[
				'name[~]'=>$query,
				'author[~]'=>$query,
				'ISBN[~]'=>$query
				],
			"ORDER" =>  ["add_time" => "DESC"],	//查询10条
			"LIMIT" => [$start,$end],
			"status" => 1
			]);
		$is_done = false;				//默认没有完成
		if(count($book)<($per_page))//不足个数说明已经返回完毕
        	$is_done = true;
		foreach ($book as &$book_)
		{
			$book_['seller_sex'] = $db->get("user_info","sex",["user_id" => $book_['user_id']]);
			$book_['seller_name'] = $db->get("user_info","nick_name",['id'=> $book_['user_id']]);
		}
		unset($book_);
		$res['book'] = $book;
		$res['is_done'] = $is_done;
		return $res;
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
		$res = $db->has("book_info",[
			"user_id"	=>	$uid,
			"name"	=>	$name,
			"old_price"	=>	$old_price,
			"now_price"	=>	$now_price,
			"author"	=>	$author,
			"publisher"	=>	$publisher,
			"quality"	=>	$quality,
			"ISBN"	=>	$ISBN,
			"num"	=>	$num,
			"classify"	=>	$classify,
			"remark"	=>	$remark,
			"status" => 1,
			"pic_url"	=>	$pic_url]);
		if ($res) {
			return 2;	//2：重复提交
		}
		else 			//防止重复提交
		{
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
			"pic_url"	=>	$pic_url,
			"status" => 1
			]);
			$num = $db->count("book_info", ["user_id" => $uid,"status" => 1]);
			$db->update("user_info",[

				"sell_num"=>$num

				],["user_id"=>$uid]);
			if($res)
				return 1;
			else
				return 0;
		}
	}
	function get_book_info($book_id)
	{
		global $db;
		$re = $db->get("book_info",[
			"[>]user_info" => ["user_id" => "user_id"]
		],[
			"user_info.avator_url",
			"user_info.nick_name",
			"user_info.sell_num",
			"user_info.sex",
			"user_info.user_sign",
			"book_info.id",
			"book_info.user_id",
			"book_info.name",
			"book_info.pic_url",
			"book_info.old_price",
			"book_info.now_price",
			"book_info.author",
			"book_info.publisher",
			"book_info.quality",
			"book_info.add_time",
			"book_info.ISBN",
			"book_info.num",
			"book_info.remark",
			"book_info.classify"
		],[
			'book_info.id'=>$book_id
			]);
		return $re;
	}
	function delete_book($book_id)
	{
		global $db;
		$res = $db->update("book_info",["status"=>0],["id"=>$book_id]);
		if ($res->rowCount() > 0) {
			$status['status'] = 1;
			return $status;
		}
		else{
			$status['status'] = 0;
			return $status;
		}
	}
	function update_book($uid,$ISBN,$name,$author,$publisher,$old_price,$now_price,$num,$classify,$quality,$remark,$pic_url,$book_id)
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
		$res = $db->has("book_info",[
			"user_id"	=>	$uid,
			"name"	=>	$name,
			"old_price"	=>	$old_price,
			"now_price"	=>	$now_price,
			"author"	=>	$author,
			"publisher"	=>	$publisher,
			"quality"	=>	$quality,
			"ISBN"	=>	$ISBN,
			"num"	=>	$num,
			"classify"	=>	$classify,
			"remark"	=>	$remark,
			"status" => 1,
			"pic_url"	=>	$pic_url]);
		if ($res) {
			return 2;	//2：重复提交
		}
		else 			//防止重复提交
		{
			$res = $db->update("book_info",[

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
			"pic_url"	=>	$pic_url,
			"status" => 1
			],[
				'id'=>$book_id
				]);
			if($res)
				return 1;
			else
				return 0;
		}
	}