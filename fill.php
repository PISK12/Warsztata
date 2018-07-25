<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 2018-07-23
	 * Time: 12:02
	 */
	?>



<?php
	require_once "config.php";
	require_once "Database.php";
	require_once "functions.php";
	require_once "template.php";
?>


<?php
	$database=new Database($fileNameDatabase);


	$result=$database->database->query("SELECT count(*) as total from Clients");
	$data=$result->fetchArray(SQLITE3_ASSOC);
	if(!$data["total"]){
		fillFakeClients(100,$database);
	}

	$result=$database->database->query("SELECT count(*) as total from PhoneNumberClients");
	$data=$result->fetchArray(SQLITE3_ASSOC);
	if(!$data["total"]){
		fillFakeNumbers(0,$database);
	}

	$result=$database->database->query("SELECT count(*) as total from CarBrands");
	$data=$result->fetchArray(SQLITE3_ASSOC);
	if(!$data["total"]){
		if ($file = fopen($fileNameListCarBrand, "r")) {
			while(!feof($file)) {
				$line = fgets($file);
				$database->addNewCarBrand($line);
			}
			fclose($file);
		}
	}

	$result=$database->database->query("SELECT count(*) as total from CarModels");
	$data=$result->fetchArray(SQLITE3_ASSOC);
	if(!$data["total"]){
		fillFakeCarModel(6,0,$database);
	}

	$result=$database->database->query("SELECT count(*) as total from Cars");
	$data=$result->fetchArray(SQLITE3_ASSOC);
	if(!$data["total"]){
		fillFakeCars($database);
	}

	$result=$database->database->query("SELECT count(*) as total from Client_Car");
	$data=$result->fetchArray(SQLITE3_ASSOC);
	if(!$data["total"]){
		fillFakeClient_Car($database);
	}
	template("");
	?>
