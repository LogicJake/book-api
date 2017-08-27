<?php
    require_once './include/book.function.php';
    if(isset($_GET['book_id']))
    {
        $result = get_book_info($_GET['book_id']);
        Result::success($result);
    }
    else
    {
        Result::error('no book id');
    }