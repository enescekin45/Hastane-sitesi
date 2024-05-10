<?php
require_once "importance.php";

if(!User::loggedIn()){
    Config::redir("login.php");
}

class addDonation  {
    public static function addDonation($hastaAdi, $hastaYasi, $kanGrubu, $rhFaktoru, $bagisTarihi, $bagisSaati, $hastaneAdi) {

        Messages::success("Kan bağışı başarıyla eklendi.");
        Config::redir("kan.php"); // Kan ekleme sayfasına geri dön
    }
}

if(isset($_POST['submit'])) {
    $hastaAdi = $_POST['Hasta_Adı'];
    $hastaYasi = $_POST['Hasta_Yaşı'];
    $kanGrubu = $_POST['Hasta_Kan_Grubu'];
    $rhFaktoru = $_POST['Rh_Faktörü'];
    $bagisTarihi = $_POST['Bağış_Tarihi'];
    $bagisSaati = $_POST['Bağış_Saati'];
    $hastaneAdi = $_POST['Hastane_Adi'];

    addDonation::addDonation($hastaAdi, $hastaYasi, $kanGrubu, $rhFaktoru, $bagisTarihi, $bagisSaati, $hastaneAdi);
}

?>

<html>
<head>
    <title>Kan Bağışı Ekleme - <?php echo CONFIG::SİSTEM_ADI; ?></title>
    <?php require_once "inc/head.inc.php"; ?>
</head>
<body>
    <?php require_once "inc/header.inc.php"; ?>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div>
            <div class='col-md-7'>
                <div class='content-area'>
                    <div class='content-header'>
                        <h2>Kan Bağışı Ekle <small>Yeni kan bağışı mı?</small></h2>
                    </div>
                    <?php require_once "inc/alerts.inc.php"; ?>
                    <div class='content-body'>
                        <div class='form-holder' style='margin-top: 50px;'>
                            <form method='post'>
                                <div class='form-group'>
                                    <label>Hasta Adı</label>
                                    <input type='text' name='Hasta_Adı' class='form-control' required>
                                </div>
                                <div class='form-group'>
                                    <label>Hasta Yaşı</label>
                                    <input type='number' name='Hasta_Yaşı' class='form-control' required>
                                </div>
                                <div class='form-group'>
                                    <label>Kan Grubu</label>
                                    <input type='text' name='Hasta_Kan_Grubu' class='form-control' required>
                                </div>
                                <div class='form-group'>
                                    <label>Rh Faktörü</label>
                                    <input type='text' name='Rh_Faktörü' class='form-control' required>
                                </div>
                                <div class='form-group'>
                                    <label>Bağış Tarihi</label>
                                    <input type='date' name='Bağış_Tarihi' class='form-control' required>
                                </div>
                                <div class='form-group'>
                                    <label>Bağış Saati</label>
                                    <input type='time' name='Bağış_Saati' class='form-control' required>
                                </div>
                                <div class='form-group'>
                                    <label>Hastane Adı</label>
                                    <input type='text' name='Hastane_Adi' class='form-control' required>
                                </div>
                                <button type='submit' name='submit' class='btn btn-primary'>Kan Bağışı Ekle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-md-3'>
                <img src='images/doc-background-one.png' class='img-responsive'>
            </div>
        </div>
    </div>
</body>
</html>
