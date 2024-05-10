<?php 

class DashboardUi{
    // Başlık, sayı ve URL parametrelerini kullanarak bir panoyu çizen bir metot
    public static function draw($title, $count, $url){
        echo "
            <div class='col-md-4'> 
                <div class='inner-panel'> 
                    <h3>$title</h3>
                    <span class='d-count'>$count</span>
                    <a href='$url'>View &#8594;</a>
                </div> 
            </div> 
        ";
    }
} 
?>
