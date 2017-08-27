<?php
require_once './include/book.function.php';
$result = get_book($GLOBALS['uid'],$_GET['type'],$_GET['page']);
Result::success($result);
