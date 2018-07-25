<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 2018-07-23
	 * Time: 14:23
	 */
	?>


<?php
	require_once "config.php";
	require_once "Database.php";
	require_once "template.php";
?>



<?php
	if(isset($_GET['query'])){
		$database=new Database($fileNameDatabase);
		$results=$database->getAllInformationAboutClientByIdClient($_GET['query']);
	}elseif (isset($_GET['idClient'])){
		$database=new Database($fileNameDatabase);
		$results=$database->getAllInformationAboutClientByIdClient($_GET['idClient']);
	}else header("Location: find.php");

	if (isset($results)){
		$content="";
		while ($table = $results->fetchArray(SQLITE3_ASSOC)) {
			$content=$content."<br>";
			$content=$content."<p>".'idClient'.": ".$table['idClient']."</p>";
			$content=$content."<p>".'firstName'.": ".$table['firstName']."</p>";
			$content=$content."<p>".'lastName'.": ".$table['lastName']."</p>";
			$content=$content."<p>".'phoneNumberClient'.": ".$table['phoneNumberClient']."</p>";
			$content=$content."<a href="."addCar.php?idClient=".$table['idClient'].">Add Car"."</a>";
		}
		$content="<br><br>";
		$results=$database->getCarFromIdClient($_GET);
		while ($table = $results->fetchArray(SQLITE3_ASSOC)) {
			$content=$content."<br>";
			$content=$content."<p>".'idClient'.": ".$table['idClient']."</p>";
			$content=$content."<p>".'firstName'.": ".$table['firstName']."</p>";
			$content=$content."<p>".'lastName'.": ".$table['lastName']."</p>";
			$content=$content."<p>".'phoneNumberClient'.": ".$table['phoneNumberClient']."</p>";
			$content=$content."<a href="."addCar.php?idClient=".$table['idClient'].">Add Car"."</a>";
		}
	}

	template($content);
?>
