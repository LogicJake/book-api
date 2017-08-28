<?php
require_once './include/book.function.php';
if(isset($_GET['bookid'])){
	$result = delete_book($_GET['bookid']);
    Result::success($result);
}
Result::error('error');