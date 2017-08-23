<?php
require_once './include/book.function.php';
if(isset($_GET['ISBN'],$_GET['name'],$_GET['author'],$_GET['publisher'],$_GET['old_price'],$_GET['now_price'],$_GET['num'],$_GET['classify'],$_GET['quality'],$_GET['remark'])) {
        $result['result'] = add_book($GLOBALS['uid'],urldecode($_GET['ISBN']),urldecode($_GET['name']),urldecode($_GET['author']),urldecode($_GET['publisher']),urldecode($_GET['old_price']),urldecode($_GET['now_price']),urldecode($_GET['num']),urldecode($_GET['classify']),urldecode($_GET['quality']),urldecode($_GET['remark']),urldecode($_GET['image_url']));
        Result::success($result);
}
Result::error('error');