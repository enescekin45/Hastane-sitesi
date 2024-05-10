<?php 
require_once "importance.php"; 

// Kullanıcı giriş yapmamışsa giriş sayfasına yönlendir
if(!User::loggedIn()){
    Config::redir("login.php"); 
}
?> 

<html>
<head>
    <title>Salgın Ekleme<?php echo CONFIG::SİSTEM_ADI; ?></title>
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
                        Salgın <small>Bir salgını kaydedin</small>
                    </div>
                    <?php require_once "inc/alerts.inc.php";  ?> 
                    <div class='content-body'> 
                        <div class='form-holder'> <br />
                            <?php 
                                // Formdan gelen verileri al
                                if(isset($_GET['token'])){
                                    $token = $_GET['token']; 
                                    $Outbreak = Outbreak::get($token, "Outbreak");
                                    $comments = Outbreak::get($token, "comments");
                                    $location = Outbreak::get($token, "location");
                                    $measures = Outbreak::get($token, "measures");
                                } else {
                                    $token = ""; 
                                    $Outbreak = "";
                                    $comments = ""; 
                                    $location = "";
                                    $measures = ""; 
                                }
                                
                                // Form gönderildiğinde
                                if(isset($_POST['Oreautbk'])){
                                    $Outbreak = $_POST['Outbreak']; 
                                    $comments = $_POST['comments'];
                                    $location = $_POST['location']; 
                                    $measures = $_POST['measures']; 
                                    
                                    // Form girişlerini kontrol et
                                    if($outbreak == "" || $comments == "" || $location == "" || $measures == ""){
                                        Messages::error("Tüm alanları doldurmalısınız");
                                    } else {
                                        // Salgın ekleme veya düzenleme işlemini gerçekleştir
                                        Outbreakn::add($token, $Outbreak, $comments, $location, $measures);
                                    }
                                }
                                
                                // Formu oluştur
                                $form = new Form(2, "post"); 
                                $form->init(); 
                                $form->textBox("Salgın", 'Salgın', 'text', "$Outbreak", '');
                                $form->textarea("Yorumlar", "yorumlar", "$comments");
                                $form->textBox("Konum", 'konum', 'text', "$location", '');
                                $form->textarea("Önlemler", "önlemler", "$measures");
                                if($token == ""){
                                    $form->close("Bir salgın ekleyin");
                                } else {
                                    $form->close("Salgını Düzenle");
                                }
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
