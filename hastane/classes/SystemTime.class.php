<?php 

// Sistem zamanıyla ilgili işlevler içeren bir sınıf
class SystemTime{
    // Belirtilen bir zaman damgasını tarih biçiminde döndürür
    public static function getD($timestamp){
        return strftime(date("d-m-Y", $timestamp));
    }
    
    // Belirtilen bir zaman damgasını saat biçiminde döndürür
    public static function getT($timestamp){ 
        return date("g:i a", $timestamp); 
    }
} 
?>
