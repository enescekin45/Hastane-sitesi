<?php 
require_once "importance.php"; // Gerekli dosyaları içeri aktar

if(!User::loggedIn()){
	Config::redir("login.php"); // Kullanıcı oturum açmamışsa, giriş sayfasına yönlendir
}
?> 

<html>
<head>
	<title><?php echo CONFIG::SİSTEM_ADI; ?></title> <!-- Sayfa başlığı -->
	<?php require_once "inc/head.inc.php";  ?> <!-- Başlık kısmını içeri aktar -->
</head>
<body>
	<?php require_once "inc/header.inc.php"; ?> <!-- Başlık bölümünü içeri aktar -->
	<div class='container-fluid'>
		<div class='row'>
			<div class='col-md-2'><?php require_once "inc/sidebar.inc.php"; ?></div> <!-- Yan çubuğu içeri aktar -->
			<div class='col-md-7'>
				<div class='content-area'> 
					<div class='content-header'> 
						<?php echo "$userFirstName $userSecondName" ; ?> <small><?php echo $userRole; ?></small> <!-- Kullanıcı adı ve rolü -->
					</div>
					<div class='content-body'> 
						<?php $token = $_GET['token']; User::profile($token);  ?> <!-- Kullanıcı profili bilgilerini getirme fonksiyonunu çağır -->
					</div> 
				</div> 
			</div>
			<div class='col-md-3'>
				<img src='images/doc-background-one.png' class='img-responsive' /> <!-- Sağ taraftaki görsel -->
			</div> 
		</div> 
	</div> 
</body>
</html>
