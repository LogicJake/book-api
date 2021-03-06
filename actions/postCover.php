<?php
    //文件存储路径
    $file_path = $upload_cover;
    //664权限为文件属主和属组用户可读和写，其他用户只读。
    if(is_dir($file_path)!=TRUE){
        mkdir($file_path,0664);
    }
    //定义允许上传的文件扩展名
    $ext_arr = array( "jpg", "jpeg", "png", "bmp");

    if (empty($_FILES) === false) {
        //判断检查
        if($_FILES["file"]["size"] > 1024*1024){
            // $result['msg'] = '对不起，您上传的照片超过了2M。';
            $result['status'] = 1;
            Result::success($result);
        }
        if($_FILES["file"]["error"] > 0){
            // $result['msg'] = "文件上传发生错误：".$_FILES["file"]["error"];
            $result['status'] = 2;
            Result::success($result);
        }

        //获得文件扩展名
        $temp_arr = explode(".", $_FILES["file"]["name"]);
        $file_ext = array_pop($temp_arr);
        $file_ext = trim($file_ext);
        $file_ext = strtolower($file_ext);
        //检查扩展名
        if (in_array($file_ext, $ext_arr) === false) {
            // $result['msg'] = "上传文件扩展名是不允许的扩展名。";
            $result['status'] = 3;
            Result::success($result);
        }
        $coverSalt = '一个调试的微笑';
        $coverName = md5($tokenSalt . time() . $GLOBALS['uid'] . $coverSalt);
        $new_cover_url = $coverName . ".jpg";
        move_uploaded_file($_FILES["file"]["tmp_name"],"$file_path"."/" . $new_cover_url);

        $result['cover_url'] = $new_cover_url;
        $result['test_url'] = $file_path."/" . $new_cover_url;
        // $result['msg'] = "文件上传成功！";
        $result['status'] = 200;
        Result::success($result);
    } else {
        // $result['msg'] = "无正确的文件上传";
        $result['status'] = 404;
        Result::success($result);
    }
