<?php 
// importance.php dosyasını dahil et
require_once "importance.php"; 

// GET veya POST isteğine bağlı olarak "action" değişkenini al
if(isset($_GET['action'])){
    $action = $_GET['action'];
}

if(isset($_POST['action'])){
    $action = $_POST['action'];
}

// Eğer "action" değişkeni "remove-doc" ise
if($action == "remove-doc"){
    // Doktor token'ını al
    $doc = $_GET['token'];
    // Doktoru sil
    Doctor::delete($doc);
    // Kullanıcıyı "doctors-record.php" sayfasına yönlendir ve mesaj göster
    Config::redir("doctors-record.php?message=Doctor has been removed!"); 
}

// Eğer "action" değişkeni "delete-outbreak" ise
if($action == "delete-outbreak"){
    // Salgın token'ını al
    $token = $_GET['token'];
    // Salgını sil
    Outbreak::delete($token);
    // Kullanıcıyı "outbreaks.php" sayfasına yönlendir ve mesaj göster
    Config::redir("outbreaks.php?message=OUtbreak has been deleted!"); 
} 
?>
