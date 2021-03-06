<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
session_start();

require_once './include/result.class.php';
require_once './include/Medoo.php';
require_once './include/token.class.php';

use Medoo\Medoo;
$db = new Medoo([
    'database_type' => 'mysql',
    'database_name' => 'book-db',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '835410808scy',
    'charset' => 'utf8'
]);
$upload_avator = '/www/book-file/avator';
$upload_cover = '/www/book-file/cover';
// white list
$actionList = ['postLogin','postLogout','postSignup','getInfo','getBook','getSearch','addbook','postAvator','checktoken','postCover','getBookinfo','deleteBook','getUpdatebookinfo','postCollection','getMyCollection'];
$noTokenList = ['postLogin','postSignup'];

if (!isset($_GET['_action'])) {
    Result::error('missing _action');
}
if (!in_array($_GET['_action'], $actionList)) {
    Result::error('_action error');
}

if (in_array($_GET['_action'], $noTokenList)){//如果是不需要token的 action 直接进入
    require_once "actions/{$_GET['_action']}.php";

} else {//token验证
    if (!isset($_GET['token'])){//无token错误
        Result::error('no token');
    }
    if(Token::userid($_GET['token']) < 1){//token不存在终止
        Result::error('token wrong');
    }
    if ($_GET['_action'] == 'checktoken') {   //是测试就此打住返回
        Result::error('token success');
    }
    //其余为正确情况 全局并进入action
    $GLOBALS['uid'] = Token::userid($_GET['token']);
    require_once "actions/{$_GET['_action']}.php";
}