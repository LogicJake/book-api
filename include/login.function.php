<?php

require_once 'token.class.php';
require_once 'info.function.php';

    /**
        *@param $num user_num
        *@param $passwd user_password
        *@return user's id and has complete personal infomation or not
    */
    function check_login($user_name,$user_passwd)
    {
       global $db;
        $re =$db->has("user", [
                "user_name" => $user_name,
                "status" => 1
            ]
            );
        if(!$re)
        {
            $return['status'] = 2;                  //查无此人
        }
        else
        {
            $re = $db->get("user",[
                "id",
                "user_name",
            ],[
                "user_name" => $user_name,
                "user_passwd" => $user_passwd,
                "status" => 1
            ]);
            if($re)
            {
                $token = Token::addToken($re['id']);
                $return['status'] = 1;
                $return['id'] = $re['id'];
                $return['user_name'] = $re['user_name'];
                $return['token'] = $token;
            }
            else
            {
                $return['status'] = 0;          //密码错误
            }
        }
        return $return;

    }