<?php 

class Dashboard extends DashboardUi { // Miras alma kullanılarak DashboardUi sınıfından türetiliyor
    // Hasta kayıt sayısını döndüren metot
    public static function getPatientRecords(){
        $query = Db::fetch("patients", "", "", "", "id DESC", "", "");
        return Db::count($query);
    }
    
    // Tüm hastaların sayısını döndüren metot
    public static function patients(){
        $query = Db::fetch("patients", "", "", "", "", "", "number");
        return Db::count($query);
    }

    // Kan bağışı bilgilerini dizi olarak döndüren metot
    public static function getKansaymak(){
        $query = Db::fetch("kan", "", "", "", "", "", "");
        $kanBilgileri = array();
    
        while ($row = Db::assoc($query)) {
            // Her satırı diziye ekler
            $kanBilgileri[] = array(
                'Hasta_ Adı' => $row['Hasta_ Adı'],
                'Kan_gurbu' => $row['Kan_gurbu']
            );
        }
    
        return $kanBilgileri;
    }
    
    // Kullanıcının randevu aldığı toplam randevu sayısını döndüren metot
    public static function Appointments(){
        $query = Db::fetch("appointment", "", "too = ? ", User::getToken(), "", "", "");
        return Db::count($query);
    }
    
    // Kullanıcının cevapladığı toplam randevu sayısını döndüren metot
    public static function repliedAppointMents(){
        $query = Db::fetch("appointment", "", "fromm = ? ", User::getToken(), "", "", "");
        return Db::count($query); 
    }
    
    // HIV hastalarının sayısını döndüren metot
    public static function hivPatients(){
        $query = Db::fetch("hiv", "", "", "", "", "",  "");
        return Db::count($query);
    }
    
    // Doktorların sayısını döndüren metot
    public static function doctors(){
        $query = Db::fetch("users", "", "status = ? ", "2", "", "",  "");
        return Db::count($query);
    }
    
    // Salgın kayıtlarının sayısını döndüren metot
    public static function Outbreak(){
        $query = Db::fetch("Outbreak", "", "", "", "", "",  "");
        return Db::count($query);
    }
}
