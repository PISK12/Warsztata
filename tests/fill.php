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

	if (!isset($_GET['q'])) {
		$result = $database->database->query("SELECT count(*) as total from Clients");
		$data = $result->fetchArray(SQLITE3_ASSOC);
		if (!$data["total"]) {
			fillFakeClients(100, $database);
		}
		echo "fillFakeClients";
		header("Location: fill.php?q=a");
	} elseif (isset($_GET['q']) and $_GET['q'] == 'a') {
		$result = $database->database->query("SELECT count(*) as total from PhoneNumberClients");
		$data = $result->fetchArray(SQLITE3_ASSOC);
		if (!$data["total"]) {
			fillFakeNumbers(0, $database);
		}
		echo "fillFakeNumbers";
		header("Location: fill.php?q=b");
	} elseif (isset($_GET['q']) and $_GET['q'] == 'b') {
		$result = $database->database->query("SELECT count(*) as total from CarBrands");
		$data = $result->fetchArray(SQLITE3_ASSOC);
		if (!$data["total"]) {
			if ($file = fopen($fileNameListCarBrand, "r")) {
				while (!feof($file)) {
					$line = fgets($file);
					$database->addNewCarBrand($line);
				}
				fclose($file);
			}
		}
		echo "addNewCarBrand";
		header("Location: fill.php?q=c");
	} elseif (isset($_GET['q']) and $_GET['q'] == 'c') {
		$result = $database->database->query("SELECT count(*) as total from CarModels");
		$data = $result->fetchArray(SQLITE3_ASSOC);
		if (!$data["total"]) {
			fillFakeCarModel(6, 0, $database);
		}
		echo "fillFakeCarModel";
		header("Location: fill.php?q=d");
	} elseif (isset($_GET['q']) and $_GET['q'] == 'd') {
		$result = $database->database->query("SELECT count(*) as total from Cars");
		$data = $result->fetchArray(SQLITE3_ASSOC);
		if (!$data["total"]) {
			fillFakeCars($database);
		}
		echo "fillFakeCars";
		header("Location: fill.php?q=e");
	} elseif (isset($_GET['q']) and $_GET['q'] == 'e') {
		$result = $database->database->query("SELECT count(*) as total from Client_Car");
		$data = $result->fetchArray(SQLITE3_ASSOC);
		if (!$data["total"]) {
			fillFakeClient_Car($database);
		}
		echo "fillFakeClient_Car";
		header("Location: fill.php?q=f");
	} elseif (isset($_GET['q']) and $_GET['q'] == 'f') {
		$result = $database->database->query("SELECT count(*) as total from Diary");
		$data = $result->fetchArray(SQLITE3_ASSOC);
		if (!$data["total"]) {
			fillFakeDiary($database);
		}
		echo "fillFakeDiary";
		header("Location: fill.php?q=g");
	}
	template("");
	?>
