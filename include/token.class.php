<?php

class Token {

    /**
     * 通过token获取uid
     *
     * @param  $token
     * @return 成功返回uid 失败返回小于一的数
     */
    public static function userid($token){
        global $db;
        $re = $db->get('token',[
            'userid'
        ],[
            "tokenName" => $token
        ]);

        if(!$re) {
            return 0;
        } 
        else {
            return $re['userid'];
        }
    
    }

    /**
     * 添加一个token
     *
     * @param [int] $uid
     * @return token名
     */
    public static function addToken($uid) {
        global $db;
        $tokenSalt = '甲鱼666';
        $tokenName = md5($tokenSalt . time() . $uid . $tokenSalt);
        if ($db->has('token',['userid' => $uid])) {
            $db->update('token',['tokenName' => $tokenName],['userid' => $uid]);
        }
        else
        {
            $db->insert('token',['userid' => $uid,'tokenName' => $tokenName]);
        }
        return $tokenName;
    }

    /**
     * 删除一个token
     *
     * @param integer $uid 传入要删除的token对应的uid 优先于token值
     * @param integer $token 传入要删除的token 只有在不传入uid的时候起效
     * @return void
     */
    public static function deleteToken($uid = -1, $token = -1) {
        global $db;

        if($uid != -1) {
            $db->delete('token',[
                'userid' => $uid
            ]);
        } else {
            $db->delete('token',[
                'tokenName' => token
            ]);
        }
    }
}
