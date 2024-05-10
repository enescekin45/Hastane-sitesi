<?php 

class Outbreak{
    // Salgın ekler veya düzenler
    public static function add($token, $OutbreakDisease, $comments, $location, $measures){
        // Token boşsa yeni bir salgın ekler, doluysa mevcut salgını düzenler
        if($token == ""){
            $time = time(); 
            $token = md5(uniqid().time().unixtojd()); // Benzersiz bir token oluşturur
            Db::insert( "Outbreak",
                array("Outbreak", "comments", "location", "cTime", "measures", "token"), 
                array($OutbreakDisease, $comments, $location, $time,  $measures, $token)
            );
            
            Messages::success("Salgın eklendi, doktorlar bunu görebilecek ve gerekli önlemleri alabilecek");
        } else {
            // Token doluysa mevcut salgını düzenler
            self::edit($token, $OutbreakDisease, $comments, $location, $measures);
            Messages::success("Salgın düzenlendi. <strong><a href='Outbreak.php'>Düzenlenmiş kaydı görüntüle</a></strong>");
        }
    }
    
    // Kayıtlı salgınları yükler
    public static function load(){
        $query = Db::fetch("Outbreak", "", "", "", "id DESC","", "");
        if(!Db::count($query)){
            Messages::info("Şu anda kaydedilmiş herhangi bir salgın bulunmamaktadır");
            return; 
        }
        
        echo "<div class='form-holder'>";
        Table::start();
        $header = array("Salgın", "Yorumlar", "Konum", "Kaydedildi", "Önlemler","Eylem"); 
        $body = array(); 
        Table::header($header); 
        
        while($data = Db::assoc($query) ){
            Table::body(array($data['Outbreak'], $data['comments'] , $data['location'], SystemTime::getD($data['cTime']), $data['measures'], "<center><a href='add-Outbreak.php?token=".$data['token']."'>Düzenle</a></center>"));
        }
        
        Table::close();
        echo "</div>";
    }
    
    // Belirli bir salgını siler
    public static function delete($token){
        Db::delete("Outbreak", " token = ? ", $token); 
    }
    
    // Belirli bir salgına ait bilgiyi getirir
    public static function get($token, $field){
        $query = Db::fetch("Outbreak", "$field", "token = ? ", "$token", "id DESC","", "");
        $data = Db::num($query); 
        return $data[0];
    }
    
    // Belirli bir salgını düzenler
    public static function edit($token, $OutbreakDisease, $comments, $location, $measures){
        Db::update("Outbreak", 
            array("Outbreak", "comments", "location",  "measures"), 
            array($OutbreakDisease, $comments, $location, $measures),
            "token = ? ", $token);
    }
}
