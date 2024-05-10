<?php 


class Db{

	public static function handleSQLError($e){
		// Hata yönetimi burada yapılacak
		die($e->getMessage());
	}

	public static function connect(){
		try{
			$db = new PDO("mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME,Config::DB_USER, Config::DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(Exception $e){
			self::handleSQLError($e);
		}
		return $db;
	}

	// Diğer metodlar burada...

	public static function fetch($table, $columns, $whereClause, $whereValue, $orderBy, $limit, $groupBy){
		if($limit == ""){
			$limit = ""; 
		} else {
			$limit = " LIMIT $limit "; 
		}
		if($orderBy == ""){
			$orderBy = "";
		} else {
			$orderBy = " ORDER BY $orderBy "; 
		}
		if($groupBy == ""){
			$groupBy = "";
		} else {
			$groupBy = " GROUP BY $groupBy";  // Boşluk ekledim
		}
		$con = self::connect(); 
		if($columns == ""){
			
			$query = $con->prepare("SELECT * FROM $table WHERE $whereClause $groupBy $orderBy $limit");
			if($whereValue != ""){
				if(is_array($whereValue)){
					$n = 0; 
					$countWhereValue = count($whereValue);
					while($n < $countWhereValue){
						$paramsCount = $n + 1; 
						$query->bindParam($paramsCount, $whereValue[$n]);
						$n++;
					}
				} else {
					$query->bindParam(1, $whereValue); 
				}
			} else {
				$query = $con->prepare("SELECT * FROM $table $groupBy $orderBy $limit");
			}
		} else {
			
			$sql = "SELECT "; 
			if(is_array($columns)){
				$colsCount = count($columns); 
				$start = 0; 
				while($start < $colsCount){
					$commas = $start + 1; 
					if($commas == $colsCount){
						$sql .= $columns[$start]." ";
					} else {
						$sql .= $columns[$start].", "; 
					}
					$start ++; 
				}
			} else {
				$sql .= "$columns ";
			}
			
			if($whereValue != ""){
				$sql .= "FROM $table WHERE $whereClause $groupBy $orderBy $limit"; 
				$query = $con->prepare($sql); 
				if(is_array($whereValue)){
					$n = 0; 
					$countWhereValue = count($whereValue);
					while($n < $countWhereValue){
						$paramsCount = $n + 1; 
						$query->bindParam($paramsCount, $whereValue[$n]);
						$n++;
					}
				} else {
					$query->bindParam(1, $whereValue); 
				}   
			} else {
				$sql .= "FROM $table $groupBy $orderBy $limit"; 
				$query = $con->prepare($sql); 
				
			}
		}
		$query->execute(); 
		return $query; 
	}
	
	public static function table($table, array $cols){
		// Tablo oluşturma işlevi burada yapılacak
	}

	public static function count($query){
		return $query->rowCount();
	}

	public static function assoc($query){
		return $query->fetch(PDO::FETCH_ASSOC);
	}

	public static function num($query){
		return $query->fetch(PDO::FETCH_NUM);
	}

	public static function getCount($table, $where, $whereValue, $order, $limit){
		return self::fetchAll($table, $where, $whereValue, $order, $limit)->rowCount();
	}

	public static function insert($table, $fields, $values) {
        $con = self::connect(); 
        try {
            $placeholders = rtrim(str_repeat('?,', count($fields)), ',');
            $stmt = $con->prepare("INSERT INTO $table (".implode(',', $fields).") VALUES ($placeholders)");
            $stmt->execute($values);
        } catch(Exception $e) {
            self::handleSQLError($e);
        }
	}

	public static function form(array $label, $labelDistance, array $name, array $type, $submit){		

		$form = "<form method='post' class='form-horizontal' action='' style='margin-top: 20px;'>";
		$startForm = 0; 
		$totalFields = count($name); 
		while($startForm < $totalFields){
			$inputDistance = 12 - (int)$labelDistance; 
			$form .="<div class='form-group'>";
			$form .="<label class='col-md-$labelDistance'>".$label[$startForm]."</label>";
			$form .="<div class='col-md-$inputDistance'><input type='".$type[$startForm]."' name='".$name[$startForm]."' class='form-control'/></div>";
			$form .="</div>";

			$startForm ++;
		}

		$form .= "<div class='form-group'>
					<div class='col-md-$labelDistance'></div> 
					<div class='col-md-$inputDistance'> 
						<input type='submit' value='$submit' class='btn btn-primary' />
					</div> 
		          </div> "; 
		$form .= "</form>"; 

		echo $form; 

	}
	
	
	
	public static function formSpecial($label, $labelDistance,  $name, $type,  $textAreaLabel, $textAreaName,  $selectLabel, $select, $selectOptions,  $submit){
			

		$form = "<form method='post' class='form-horizontal' action='' style='margin-top: 20px;'>";
		$startForm = 0; 
		$totalFields = count($name); 
		while($startForm < $totalFields){
			$inputDistance = 12 - (int)$labelDistance; 
			$form .="<div class='form-group'>";
			$form .="<label class='col-md-$labelDistance'>".$label[$startForm]."</label>";
			$form .="<div class='col-md-$inputDistance'><input type='".$type[$startForm]."' name='".$name[$startForm]."' class='form-control'/></div>";
			$form .="</div>";

			$startForm ++;
		}
		
		if($textAreaLabel == "" || $textAreaLabel == null){
			$form .= "";
		} else {
			$startTextArea = 0; 
			
			while($startTextArea < count($textAreaLabel)){
				
				$form .="<div class='form-group'>";
				$form .="<label class='col-md-$labelDistance'>".$textAreaLabel[$startTextArea]."</label>";
				$form .="<div class='col-md-$inputDistance'><textarea name='".$textAreaName[$startTextArea]."' class='form-control'></textarea></div>";
				$form .="</div>";
				
				$startTextArea ++; 
			}
		}
		
		if($select == "" || $select == null){
			$form .= "";
		} else {
			$startSelect = 0; 
			
			while($startSelect < count($selectLabel)){
				
				$form .="<div class='form-group'>";
				$form .="<label class='col-md-$labelDistance'>".$selectLabel[$startSelect]."</label>";
				$form .="<div class='col-md-$inputDistance'><select name='".$select[$startSelect]."' class='form-control'><option value=''>--Select--</option>";
								
								$startOptions = 0; 
								while($startOptions < count($selectOptions)){
									$form .= "<option value='".$selectOptions[$startOptions]."'>".$selectOptions[$startOptions]."</option>";
									$startOptions ++; 
								}
								
				$form .="</select></div>";
				$form .="</div>";
				
				$startSelect ++; 
			}
		}
		
		

		$form .= "<div class='form-group'><div class='col-md-$labelDistance'></div><div class='col-md-$inputDistance'><input type='submit' value='$submit' class='btn btn-primary' /></div></div> "; 
		$form .= "</form>"; 

		echo $form; 

	}

	
}