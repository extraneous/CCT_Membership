<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use Jasny\Config;
$confFile = realpath(__DIR__ . '/../config.ini');
$config = new Config($confFile);

//Set up Database Connection
try {
    $db = new PDO("mysql:host=" .$config->database->host . ";dbname=" . $config->database->dbname,$config->database->username,$config->database->password);
}
catch(PDOException $e){
    echo $e->getMessage();
}

ActiveRecord\Config::initialize(function($cfg){
    global $config;
    $arConStr = 'mysql://' . $config->database->username . ':' . $config->database->password . '@localhost/' . $config->database->dbname;
    $cfg->set_model_directory($config->ar->modeldir);
    $cfg->set_connections(array(
        'development' => $arConStr));
});
\ActiveRecord\Connection::$datetime_format = 'Y-m-d H:i:s';

$strSQL = "SELECT * FROM member_import WHERE memNo <> '' ORDER BY id";
$stmt = $db->prepare($strSQL);
$stmt->execute();
while($row = $stmt->fetch(PDO::FETCH_OBJ)){
	$membership = new Membership();
	$membership->memno = $row->memNo;
	$membership->status = 'Live';
	if($row->lapsed == 'FALSE'){
		$membership->lapsed = 'N';
	} else {
		$membership->lapsed = 'Y';
		$membership->status = 'Lapsed';
		if($row->lapsed_date != ''){
			$lapsedDate = DateTime::createFromFormat('d/m/Y',$row->lapsed_date);
			$membership->lapseddate = $lapsedDate->format('Y-m-d');
		}
		if($row->manual == 'TRUE'){
			$membership->manual = 'Y';
		} else {
			$membership->manual = 'N';
		}
			
	}
	$now = new DateTime();
	$membership->entereddate = $now->format('Y-m-d h:s');
	if(trim($row->apply_date) != ''){
		$applyDate = DateTime::createFromFormat('d/m/Y',$row->apply_date);
		$membership->applydate = $applyDate;
	}		
	$membership->comments = $row->comments;
	
	
	
	$membership->save();
	$person = new Person();
	$person->title  = $row->title1;
	$person->firstname = $row->first_Name_1;
	$person->lastname = $row->last_name_1;
	
	$telno1 = trim($row->Tel_No_1);
	$telno2 = '';
	$posSlash = strpos($telno1,'/');
	if($posSlash !== FALSE){
		$telnoArr = explode('/',$telno1);
		$telno1 = trim($telnoArr[0]);
		$telno2 = trim($telnoArr[1]);
	}
	$posHyphen = strpos($telno1,'-');
	if($posHyphen !== FALSE){
		$telnoArr = explode('-',$telno1);
		$telno1 = trim($telnoArr[0]);
		$telno2 = trim($telnoArr[1]);
	}
	
	$person->telno1 = trim($telno1);
	
	if($telno2 == ''){
		if(trim($row->Tel_No_2) != ''){
			$person->telno2 = trim($row->Tel_No_2);
		}
	} else {
		$person->telno2 = $telno2;
	}
	if(trim($row->email) != ''){
		$email = filter_var($row->email,FILTER_SANITIZE_EMAIL);
		$pos = strpos($email,'#');
		if($pos !== FALSE){
			$email = substr($email,0,$pos);
		}
		$person->email = $email;
	}
	$person->giftaid = 'Unknown';
	if($row->gift_aid == 'Y'){
		$person->giftaid = 'GiftMembership';
	}
	if($row->gift_aid == 'N'){
		$person->giftaid = 'NoDeclaration';
	}
		if($row->gift_aid == 'X'){
		$person->giftaid = 'NotApplicable';
	}
	if(trim($row->gift_aid) != ''){
		$giftDate = DateTime::createFromFormat('d/m/Y',$row->gift_aid);
		$person->giftaiddate = $giftDate;
	}
	if(trim($row->gift_aid_name) != ''){
		$person->giftaidname = $row->gift_aid_name;
	}
	
	$person->save();
	
	$personMem1 			= new PersonMembership();
	$personMem1->personid 	= $person->id;
	$personMem1->memno 		= $membership->memno;
	$personMem1->save();
	
	$address = new Address();
	$address->organisation 	= $row->organisation_Name;
	$address->numberorname 	= $row->address_Line_1;
	$address->addressline1 	= $row->address_Line_2;
	$address->addressline2 	= $row->address_Line_3;
	$address->posttown 		= ucfirst(strtolower($row->post_Town));
	$address->county 		= ucfirst(strtolower($row->county));
	$address->postcode 		= $row->postCode;
	$address->county 		= $row->Country;
	$address->status 		= 'Live';
	$address->date_changed = $now->format('Y-m-d h:s');
	$address->save();
	
	$pa1 = new PersonAddress();
	$pa1->personid = $person->id;
	$pa1->addressid = $address->addressid;
	$pa1->save();
	
	if(trim($row->first_Name_2) != ''){
		$person2 = new Person();
		$person2->title  = $row->title1;
		$person2->firstname = $row->first_Name_1;
		$person2->lastname = $row->last_name_1;
		
		$person2->telno1 = trim($telno1);
		
		if($telno2 == ''){
			if(trim($row->Tel_No_2) != ''){
				$person2->telno2 = trim($row->Tel_No_2);
			}
		} else {
			$person2->telno2 = $telno2;
		}
		if(trim($row->email) != ''){
			$email = filter_var($row->email,FILTER_SANITIZE_EMAIL);
			$pos = strpos($email,'#');
			if($pos !== FALSE){
				$email = substr($email,0,$pos);
			}
			$person2->email = $email;
		}
		$person2->giftaid = 'Unknown';
		if($row->gift_aid == 'Y'){
			$person2->giftaid = 'GiftMembership';
		}
		if($row->gift_aid == 'N'){
			$person2->giftaid = 'NoDeclaration';
		}
			if($row->gift_aid == 'X'){
			$person2->giftaid = 'NotApplicable';
		}
		if(trim($row->gift_aid) != ''){
			$giftDate = DateTime::createFromFormat('d/m/Y',$row->gift_aid);
			$person2->giftaiddate = $giftDate;
		}
		if(trim($row->gift_aid_name) != ''){
			$person2->giftaidname = $row->gift_aid_name;
		}
		
		$person2->save();
		$personMem1 			= new PersonMembership();
		$personMem1->personid 	= $person2->id;
		$personMem1->memno 		= $membership->memno;
		$personMem1->save();
		
		$pa2 = new PersonAddress();
		$pa2->personid = $person2->id;
		$pa2->addressid = $address->addressid;
		$pa2->save();
	}
}