<?php
require_once './include/book.function.php';
$result = get_book($GLOBALS['uid'],$_POST['type'],$_POST['page']);
Result::success($result);
