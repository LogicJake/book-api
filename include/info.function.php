<?php

function user_info($id)
{
    global $db;
        // $re =$db->get("user_info", [*],[
        //     "user_id" => $id
        // ]);
    $has_complete = $db->has("user_info", [
            "user_id" => $id
        ]
        );
        if(!$has_complete)
        {
            $has_complete = $db->insert("user_info", [
                    "user_id" => $id
                ]
                );
        }
    $re =$db->get("user_info","*", [
            "user_id" => $id
        ]
        );
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
function update_interest($user_id,$interest,$type)
{
    switch($type)
    {
        case 'add_interest':
            return Interesting::add_interest($user_id,$interest);
            break;
        case 'delete_interest':
            return Interesting::delete_interest($user_id,$interest);
            break;
        case 'get_interest':
            return Interesting::get_interest($user_id,$interest);
            break;
    }
}