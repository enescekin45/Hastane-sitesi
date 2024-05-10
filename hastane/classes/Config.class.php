<?php 

class Config{

	const DB_HOST = "localhost"; // Veritabanı sunucusu adresi
	const DB_NAME = "hospital"; // Veritabanı adı
	const DB_USER = "root"; // Veritabanı kullanıcı adı
	const DB_PASSWORD = ""; // Veritabanı şifresi

	const SİSTEM_ADI = "EN"; // Sistem adı
	const SLOGAN = "EN"; // Slogan

	public static function redir($page){
		header("Location: $page"); // Belirli bir sayfaya yönlendirme yapar
	}

	public static function includeD(){

	}

	public static function getMonth(){
		return 2419200; // Bir ayın saniye cinsinden süresi
	}

	public static function getWeek(){
		return 604800; // Bir haftanın saniye cinsinden süresi
	}

} 
