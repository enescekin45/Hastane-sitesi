<?php 

class Form{
    
    private $_labelDistance; // Etiket ve girdi alanı arasındaki mesafe
    private $_method; // Formun HTTP metodu (GET veya POST)

    // Kurucu metod, etiket mesafesi ve HTTP metodu parametre olarak alınır
    public function __construct($labelDistance, $method){
        $this->_labelDistance = $labelDistance;
        $this->_method = $method; 
    }

    // Formu başlatır
    public function init(){
        echo "<form class='form-horizontal' method='".$this->_method."' action='' >"; 
    }

    // Etiket ve girdi alanı arasındaki mesafeyi hesaplar
    private function getDivDistance(){
        $divDistance = 12 - (int)$this->_labelDistance;
        return $divDistance;
    }

    // Metin kutusu ekler
    public function textBox($label, $name, $type,  $value,  $additionalAttr){
        if($additionalAttr == ""){
            // Ekstra özellik yoksa basit metin kutusu ekler
            echo "
                <div class='form-group'>
                    <label class='col-md-".$this->_labelDistance."'>$label</label>
                    <div class='col-md-".$this->getDivDistance()."'> 
                        <input type='$type' name='$name' value='$value' class='form-control' /> 
                    </div> 
                </div> 
            ";
        } else {
            // Ekstra özellikler varsa bunları ekler
            $formData = "
                <div class='form-group'>
                    <label class='col-md-".$this->_labelDistance."'>$label</label>
                    <div class='col-md-".$this->getDivDistance()."'> 
                        <input type='$type' name='$name' value='$value' class='form-control' "; 
                        $start = 0; 
                        
                        // Ekstra özellikleri döngüyle ekler
                        while($start < count($additionalAttr)){
                            $formData .= $additionalAttr[$start]." ";
                            $start ++; 
                        }
                        
            $formData .= " /></div> 
                </div> 
                
            ";

            echo $formData; 
        }
    }

    // Seçim kutusu ekler
    public function select($label, $name, $value, array $options){
        $select =  "
            <div class='form-group'>
                <label class='col-md-".$this->_labelDistance."'>$label</label>
                <div class='col-md-".$this->getDivDistance()."'> 
                    <select name='$name' value='$value'> <option value=''>--Select--</option>"; 
                
                    $start = 0; 
                    // Seçenekleri döngüyle ekler
                    while($start < count($options)){
                        $select .= "<option value='".$options[$start]."'>".$options[$start]."</option>";
                        $start ++; 
                    }
        $select .="
                    </select>
                </div> 
            </div> 
        ";
        
        echo $select; 
    }

    // Metin alanı ekler
    public function textarea($label, $name, $value){
        echo "
            <div class='form-group'>
                <label class='col-md-".$this->_labelDistance."'>$label</label>
                <div class='col-md-".$this->getDivDistance()."'> 
                    <textarea class='form-control' name='$name' >$value</textarea>
                </div> 
            </div> 
        ";
    }

    // Formu kapatır
    public function close($value){
        if($value == ""){
            // Eğer buton metni boşsa, sadece formu kapatır
            echo "
                <div class='form-group'>
                    <label class='col-md-".$this->_labelDistance."'></label>
                    <div class='col-md-".$this->getDivDistance()."'></div> 
                </div> 
            ";
            echo "</form>"; 
        } else {
            // Buton metni varsa, butonla birlikte formu kapatır
            echo "
                <div class='form-group'>
                    <label class='col-md-".$this->_labelDistance."'></label>
                    <div class='col-md-".$this->getDivDistance()."'> 
                        <input type='submit' value='$value' class='btn btn-primary' /> 
                    </div> 
                </div> 
            ";
            echo "</form>"; 
        }
    } 
}
