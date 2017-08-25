<?php
require_once './include/book.function.php';
if(isset($_GET['query']))
    $result = search_book($_GET['query'],$_GET['page']);
Result::success($result);