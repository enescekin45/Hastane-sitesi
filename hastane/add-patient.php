<?php 
require_once "importance.php"; 

// Kullanıcı giriş yapmamışsa giriş sayfasına yönlendir
if(!User::loggedIn()){
    Config::redir("login.php"); 
}
?> 

<html>
<head>
    <title>Hasta Ekleme - <?php echo CONFIG::SİSTEM_ADI; ?></title>
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
                    Hasta Ekle <small>Yeni hasta mı? Onları buraya ekleyin</small>
                    </div>
                    <?php require_once "inc/alerts.inc.php";  ?> 
                    <div class='content-body'>
                        <div class='form-holder' style='margin-top: 50px;'>
                            <div class='badge-header'>Hasta Detayları</div> 
                            
                            <?php
                            
                            // Formdan gelen verileri al
                            if(isset($_GET['p-number'])){
                                $patientNumber = $_GET['p-number'];
                                echo "<h3>Patient Number: $patientNumber</h3>";
                                
                                $name = $_GET['name'];
                                $location = $_GET['location'];
                                $age = $_GET['age'];
                                $gender = $_GET['gender'];
                                $phone = $_GET['phone'];
                                $dateOfBirth = $_GET['dateOfBirth'];
                                
                                $dataBirth = explode("-", $dateOfBirth);
                                
                                $dateOfBirth = preg_replace("#[^0-9-]#", "", $dataBirth[2]."-".$dataBirth[1]."-".$dataBirth[0]);
                                
                                $diagnosis = "";
                                $prescription = "";
                                $condition = "";
                            } else {
                                $patientNumber = substr(preg_replace("#[^0-9]#", "", md5(uniqid().time())), 0, 4);
                                echo "<h3 style='color: #EF3235;'>Hasta Numarası: <strong>$patientNumber</strong></h3>";
                                $name = "";
                                $location = "";
                                $age = "";
                                $gender = "";
                                $phone = "";
                                $dateOfBirth = "";
                                $diagnosis = "";
                                $prescription = "";
                                $condition = "";
                            }
                            
                            // Form gönderildiğinde
                            if(isset($_POST['p-name'])){
                                $name = $_POST['p-name'];
                                $location = $_POST['p-location']; 
                                $age = $_POST['p-age']; 
                                $phone = $_POST['p-phone'];
                                $dateOfBirth = $_POST['p-birth'];
                                $diagnosis = $_POST['p-diagnosis']; 
                                $prescription = $_POST['p-prescription'];
                                $gender = $_POST['gender']; 
                                $condition = $_POST['condition'];
                                
                                // Form girişlerini kontrol et
                                if($name == "" || $location == "" || $age == "" || $phone == "" || $dateOfBirth == "" || $diagnosis == "" || $prescription == "" || $gender == "" || $condition == ""){
                                    Messages::error("Tüm alanları doldurmalısınız");
                                } else {
                                    // Hasta ekleme işlemini gerçekleştir
                                    Patient::add($name, $location, $age, $gender, $phone, $dateOfBirth, $diagnosis, $prescription, User::getToken(), $patientNumber, $condition); 
                                }
                            }
                            
                            // Formu oluştur
                            $form = new Form(3, "post");
                            $form->init(); 
                            $form->textBox("Ad Soyad", "p-isim", "text",  "$name", ""); 
                            $form->textBox("Konum", "p-konum", "text",  "$location", "");
                            $form->textBox("Yaş", "p-yaş", "sayı",  "$age", ""); 
                            $form->textBox("Telefon", "p-telefon", "sayı",  "$phone", "");
                            $form->textBox("Doğum Tarihi", "p-doğum", "traihi", "$dateOfBirth", "");    
                            $form->textarea("Teşhis/ Semptomlar", "p-Teşhis", "$diagnosis");
                            $form->textarea("Reçete", "p-reçete", "$prescription");
                            $form->select("Cinsiyet", "cinsiyet", "$gender", array("Erkek", "Kadın", "Diğer") );
                            $form->select("Durum", "durum", "$condition", array("Yatan Hasta", "Ayakta tedavi") );
                            $form->close("Gönder ve Yazdır"); 
                            
                            ?>
                        </div> 
                    </div>
                </div> 
                
            </div>

            <div class='col-md-3'>
                <img src='images/doc-background-one.png' class='img-responsive' /> 
            </div> 
                
        </div> 
    </div> 
</body>
</html>
