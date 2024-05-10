<?php
class Kan {
    private static $db;

    // Veritabanı bağlantısını başlatır
    public static function init($db) {
        self::$db = $db;
    }

    // Belirli bir kan bağışını getirir
    public static function getKansaymak($id) {
        // Veritabanı bağlantısı kontrol edilir
        if (!self::$db) {
            throw new Exception('Veritabanı bağlantısı başlatılmadı');
        }

        // SQL sorgusu hazırlanır ve çalıştırılır
        $stmt = self::$db->prepare("SELECT * FROM kans WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        // Sonuçlar döndürülür
        return $stmt->fetch();
    }

    // Tüm kan bağışlarını yükler
    public static function load() {
        // Veritabanı bağlantısı kontrol edilir
        if (!self::$db) {
            throw new Exception('Veritabanı bağlantısı başlatılmadı');
        }

        // Tüm kan bağışlarını veritabanından alır
        $query = Db::fetch("blood_donors", "", "", "", "id DESC", "", "");
        
        // Eğer veri yoksa bilgilendirme mesajı gösterilir
        if (!Db::rhFaktoru($query)) {
            Messages::info("Şu anda kaydedilmiş herhangi bir kan bağışı bulunmamaktadır");
            return; 
        }

        // HTML çıktısı başlatılır ve tablo oluşturulur
        echo "<div class='form-holder'>";
        Table::start();
        $header = array("Bağışçı İsmi", "Yaşı", "Kan Grubu", "Rh Faktörü", "Bağış Tarihi", "İşlem"); 
        $body = array(); 

        // TODO: Tablo içeriği oluşturulmalı

        // Tablo kapatılır ve HTML çıktısı sonlandırılır
    }
}
?>