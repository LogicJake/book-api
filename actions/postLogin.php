<?php

require_once './include/ded.login.function.php';
require_once './include/login.function.php';

if(isset($_GET['user_name'],$_GET['user_passwd'])) {
    if($_GET['user_name'] && $_GET['user_passwd']) {
        $result['result'] = dedverify(urldecode($_GET['user_name']),urldecode($_GET['user_passwd']));
        if($result['result'])
        {

                 $result=ded_login(urldecode($_GET['user_name']),urldecode($_GET['user_passwd']));
                 $result['result'] = true;
        }
        Result::success($result);
    }
    Result::error('error');
}
else
{
   Result::error('error');
}