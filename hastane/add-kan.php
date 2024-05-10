<?php
// Gerekli dosyaları dahil et
require_once "importance.php";

// Oturum kontrolü yap
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Kan sınıfını başlat ve veritabanı bağlantısını kur
Kan::init(new Db());

// Eğer POST isteği gönderildiyse
if (isset($_POST['p-name'])) {
    // Formdan gelen verileri al
    $name = $_POST['p-name'];
    $kanGrup = $_POST['p-Kan_gurbu'];
    $hastaneAdi = $_POST['p-Hastane Adı'];
    $rhFaktoru = $_POST['p-rhFaktoru'];

    // Kan bilgilerini veritabanına ekle
    Kan::addKan($name, $kanGrup, $hastaneAdi, $rhFaktoru);

    // Yeni kan bilgileri eklenmişse, kullanıcıyı yönlendir
    $_SESSION['kan'] = Kan::getKansaymakId();
    header('Location: add-kan.php');
    exit();
}

// Eğer bir kan ID'si mevcutsa
if (isset($_SESSION['kan'])) {
    // Kan bilgilerini al
    $kan = Kan::getKansaymak($_SESSION['kan']);

    // Eğer kan bilgisi alınamazsa veya mevcut değilse, kullanıcıyı yönlendir
    if ($kan === NULL) {
        header('Location: add-kan.php');
        exit();
    }
} else {
    // Kan ID'si mevcut değilse, kullanıcıyı yönlendir
    header('Location: add-kan.php');
    exit();
}
?>

<html>
<head>
    <title>Kan Ekle - <?php echo CONFIG::SİSTEM_ADI; ?></title>
    <?php require_once "inc/head.inc.php";  ?> 
</head>
<body>
    <?php require_once "inc/header.inc.php"; ?> 
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div> 
            <div class='col-md-7'>
        <div class='content-area'> 
                <div class='content-header'> 
                <!-- Sayfa başlığı -->
                Kan Ekle<small>Kan Bilgileri Ekleiyin</small>
                </div>
                <div class='content-body'> 
                    <div class='form-holder'><br /><br />
                        <?php
                        // Eğer form gönderilmişse, kullanıcıyı bilgilendir
                        if(isset($_POST['p-name'])){
                            Messages::success("Kan bilgileri başarıyla eklendi.");
                        }
                        // Formu oluştur ve kullanıcıya göster
                        $form = new Form(2, "post"); 
                        $form->init(); 
                        $form->textBox("Ad Soyad", "p-name", "text", $kan['name'] ?? '');
                        $form->textBox("Kan Grup", "p-Kan_gurbu", "text", $kan['Kan_gurbu'] ?? '');
                        $form->textBox("Hastane Adı", "p-Hastane Adı", "text", $kan['hastaneAdi'] ?? '');
                        $form->textBox("Rh Faktörü", "p-rhFaktoru", "text", $kan['rhFaktoru'] ?? '');  
                        $form->close("Kan Ekle");
                        ?>
                    </div>
                </div>
                </div> 
                
            </div> 
            <!-- Kenar çubuğu -->
            <div class='col-md-3'>
                <img src='images/doc-background-one.png' class='img-responsive' /> 
            </div> 
                
        </div> 
    </div> 
</body>
</html>
