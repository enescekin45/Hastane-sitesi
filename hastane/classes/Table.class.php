<?php 

// HTML tabloları oluşturmak için kullanılan bir sınıf
class Table{
    // Tablonun başlangıç etiketini oluşturur
    public static function start(){
        echo "<table class='table table-bordered table-stripped' >"; 
    }
    
    // Tablo başlığını oluşturur
    public static function header(array $heading){
        $headingData = "<tr>";
        for($i = 0; $i < count($heading); $i++ ){
            $headingData .= "<td><strong>".$heading[$i]."</strong></td>";
        }
        $headingData .= "</tr>"; 
        
        echo $headingData;
    }
    
    // Tablo gövdesini oluşturur
    public static function body(array $body){
        $bodyData = "<tr>";
        for($j = 0; $j < count($body); $j++ ){
            $bodyData .= "<td>".$body[$j]."</td>";
        }
        $bodyData .= "</tr>";
        
        echo $bodyData;
    }
    
    // Tabloyu başlık ve gövde verileriyle birlikte oluşturur
    public static function create(array $heading, array $body){
        // Başlık oluşturma
        $headingData = "<tr>";
        for($i = 0; $i < count($heading); $i++ ){
            $headingData .= "<td><strong>".$heading[$i]."</strong></td>";
        }
        
        $headingData .= "</tr>"; 
        
        echo $headingData;
        
        // Gövde oluşturma
        $bodyData = "<tr>";
        for($j = 0; $j < count($body); $j++ ){
            $bodyData .= "<td>".$body[$j]."</td>";
        }
        $bodyData .= "</tr>";
        
        echo $bodyData;
    }
    
    // Tablonun kapanış etiketini oluşturur
    public static function close(){
        echo "</table>"; 
    }
} 
?>
