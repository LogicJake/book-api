<?php

require_once './include/ded.login.function.php';
require_once './include/login.function.php';

if(isset($_POST['user_name'],$_POST['user_passwd'])) {
    if($_POST['user_name'] && $_POST['user_passwd']) {
        $result['result'] = dedverify(urldecode($_POST['user_name']),urldecode($_POST['user_passwd']));
        if($result['result'])
        {

                 $result=ded_login(urldecode($_POST['user_name']),urldecode($_POST['user_passwd']));
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