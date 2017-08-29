<?php
require_once './include/book.function.php';
if(isset($_POST['book_id'])) {
    $result = collection($GLOBALS['uid'],$_POST['book_id']);
    Result::success($result);
}
Result::error('error');