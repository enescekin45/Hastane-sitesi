<?php 
require_once "importance.php"; 

if(!User::loggedIn()){
    Config::redir("login.php"); 
}
?> 

<html>
<head>
    <title>Kan Bilgileri - <?php echo CONFIG::SİSTEM_ADI; ?></title>
    <?php require_once "inc/head.inc.php";  ?> 
</head>
<body>
    <?php require_once "inc/header.inc.php"; ?> 
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-2'>
                <?php require_once "inc/sidebar.inc.php"; ?>
            </div> 
            <div class='col-md-10'>
                <div class='content-area'> 
                    <div class='content-header'> 
                        <h2>Kan Bilgileri</h2>
                        <p>Kan bağışıyla ilgili bilgiler</p>
                    </div>
                    <?php require_once "inc/alerts.inc.php";  ?> 
                    <div class='content-body'> 
                        <?php 
                            // Kan bilgilerini almak için bir fonksiyon çağırın ve ekrana yazdırın
                            $kanBilgileri = Dashboard::getKansaymak(); 
                            if(is_array($kanBilgileri) && !empty($kanBilgileri)) {
                                echo "<table class='table'>";
                                echo "<thead><tr><th>Hasata Adı</th><th>Kan_gurbu</th></tr></thead>";
                                echo "<tbody>";
                                foreach ($kanBilgileri as $kan) {
                                    echo "<tr>";
                                    echo "<td>".$kan['Hasta_ Adı']."</td>";
                                    if (isset($kan['Kan_gurbu'])) {
                                        echo "<td>".$kan['Kan_gurbu']."</td>";
                                    } else {
                                        echo "<td>-</td>"; // Varsa HastaAdı, yoksa boş hücre
                                    }
                                    echo "</tr>";
                                }
                                echo "</tbody>"; // tbody etiketini kapatmayı unutmayın7
                            }
                                ?>
                    </div>
                </div> 
            </div> 
        </div> 
    </div> 
</body>
</html>
