<?php 

class Messages{
    // Başarı mesajı gösterir
    public static function success($message){
        echo "<div class='alert alert-success'>$message <div class='close' data-dismiss='alert' >&times;</div></div>";
    }

    // Bilgi mesajı gösterir
    public static function info($message){
        echo "<div class='alert alert-info'>$message <div class='close' data-dismiss='alert' >&times;</div></div>";
    }

    // Hata mesajı gösterir
    public static function error($message){
        echo "<div class='alert alert-danger'>$message <div class='close' data-dismiss='alert' >&times;</div></div>";
    }
}
