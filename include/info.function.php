<?php

function init_info($id)
{
    global $db;
    $db->insert("user_info", ["user_id" => $id]);
}
function get_info($id)
{
    global $db;
    $re = $db->get("user_info",["nick_name","phone_num","qq_num","user_sign","sex","avator_url","sell_num","like_num"],
        ["user_id" => $id]);
    return $re;
}
function update_phone_num($id,$phone_num)
{
    global $db;
    $has_complete = $db->update("user_info", [
        "phone_num" => $phone_num
    ],[
        "user_id" => $id
    ]
    );
    $result['status'] = $has_complete?1:0;
    $result['key'] = $phone_num;
    return $result;
}
function update_qq_num($id,$qq_num)
{
    global $db;
    $has_complete = $db->update("user_info", [
        "qq_num" => $qq_num
    ],[
        "user_id" => $id
    ]
    );
    $result['status'] = $has_complete?1:0;
    $result['key'] = $qq_num;
    return $result;
}
function update_user_sign($id,$user_sign)
{
    global $db;
    $has_complete = $db->update("user_info", [
        "user_sign" => $user_sign
    ],[
        "user_id" => $id
    ]
    );
    $result['status'] = $has_complete?1:0;
    $result['key'] = $user_sign;
    return $result;
}
function update_sex($id,$sex)
{
    global $db;
    $has_complete = $db->update("user_info", [
        "sex" => $sex
    ],[
        "user_id" => $id
    ]
    );
    $result['status'] = $has_complete?1:0;
    $result['key'] = $sex;
    return $result;
}
function update_nick_name($id,$nickname)
{
    global $db;
    $has_complete = $db->update("user_info", [
        "nick_name" => $nickname
    ],[
        "user_id" => $id
    ]
    );
    $result['status'] = $has_complete?1:0;
    $result['key'] = $nickname;
    return $result;
}