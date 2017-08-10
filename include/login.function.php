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

    function logout($user_id)
    {
        global $db;
        $logout = $db->delete('token',['userid'=>$user_id]);
        if($logout)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    function signup($user_name,$user_passwd)
    {
        global $db;
        $re =$db->has("user", [
                "user_name" => $user_name,
            ]
            );
        if($re)
        {
             $return['status']=2;
        }
        else
        {
             $re = $db->insert("user", [
                "user_name" => $user_name,
                "user_passwd" => $user_passwd,
            ]
            );
            $re = $db->get('user',['id'],['user_name'=> $user_name]);
            $re = $re['id'];
            $token = Token::addToken($re);
            $return['token'] = $token;
            $return['status']=1;
            $return['id']=$re;
        }
        return $return;
    }