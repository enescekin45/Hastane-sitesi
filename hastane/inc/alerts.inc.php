<?php 

// Eğer 'message' parametresi varsa ve boş değilse
if(isset($_GET['message']) && $_GET['message'] !== ''){
    // 'message' parametresini bir bilgi mesajı olarak görüntüler
	Messages::info($_GET['message']);
}

?>
