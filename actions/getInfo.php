<?php
require_once './include/info.function.php';
if(isset($_POST['type'])) {
    switch($_POST['type']) {
        case 'get_info':
            $return['result'] = get_info($GLOBALS['uid']);
            break;
        case 'update_nick_num':
            $return['result'] = update_nick_name($GLOBALS['uid'],urldecode($_POST['nick_name']));
            break;
        case 'update_phone_num':
            $return['result'] = update_phone_num($GLOBALS['uid'],$_POST['phone_num']);
            break;
        case 'update_qq_num':
            $return['result'] = update_qq_num($GLOBALS['uid'],$_POST['qq_num']);
            break;
        case 'update_user_sign':
            $return['result'] = update_user_sign($GLOBALS['uid'],$_POST['user_sign']);
            break;
        case 'update_sex':
            $return['result'] = update_sex($GLOBALS['uid'],$_POST['sex']);
            break;
        case 'add_interest':
        case 'delete_interest':
        case 'get_interest':
            if($_POST['interest'])
            {
                $return['result'] = update_interest($GLOBALS['uid'],$_POST['interest'],$_POST['type']);
                break;
            }
    }
}
Result::success($return);
