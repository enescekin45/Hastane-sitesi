<?php

class HIV {
    // Yeni bir HIV verisi ekler
    public static function add($name, $age, $location, $MOD, $comments) {
        // Benzersiz bir token oluşturulur
        $token = md5(uniqid().time().$name);
        
        // Veritabanına yeni kayıt eklenir
        Db::insert("hiv",
            array("name", "age", "location", "moc", "dComments", "cTime", "token"),
            array($name, $age, $location, $MOD, $comments, time(), $token)
        );
        
        // Başarı mesajı gösterilir
        Messages::success("Veriler eklendi, teşekkürler");
    }

    // HIV verilerini yükler
    public static function load() {
        // Tüm HIV verilerini veritabanından alır
        $query = Db::fetch("hiv", "", "", "", "id DESC", "", "");

        // Eğer veri yoksa bilgilendirme mesajı gösterilir
        if (!Db::count($query)) {
            Messages::info("Şu anda HIV verisi bulunmamaktadır.");
            return;
        }
        
        // Tabloyu göstermek için HTML çıktısı başlatılır
        echo "<div class='form-holder'>";
        Table::start();
        
        // Tablo başlığı ve içeriği için başlık ve vücut verileri tanımlanır
        $header = array("Name", "Age", "Location", "Contracted Via", "Doctors Comments", "Recorded");
        $body = array();
        
        // Tablo başlığı oluşturulur
        Table::header($header);
        
        // Her bir HIV verisi için tablo vücudu oluşturulur
        while ($data = Db::assoc($query)) {
            // Tarih biçimlendirilir
            $date = strftime(date("d-m-Y", $data['cTime']));

            // Veri satırı tablo vücuduna eklenir
            Table::body(array($data['name'],
                $data['age'],
                $data['location'],
                $data['moc'],
                $data['dComments'],
                $date));
        }

        // Tablo kapatılır
        Table::close();

        // HTML çıktısı kapatılır
        echo "</div>";
    }
}
