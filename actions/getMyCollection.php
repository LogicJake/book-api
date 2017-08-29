<?php
	require_once './include/book.function.php';
	$result = get_my_collection($GLOBALS['uid'],$_GET['page']);
	Result::success($result);