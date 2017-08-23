<?php
require_once './include/book.function.php';
$result = get_book($GLOBALS['uid'],$_POST['type']);
Result::success($result);
