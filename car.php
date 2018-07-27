<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 2018-07-26
	 * Time: 12:34
	 */
?>


<?php
	require_once "config.php";
	require_once "Database.php";
	require_once "template.php";
?>


<?php


	if (isset($_GET['idCar'])) {
		$database = new Database($fileNameDatabase);
		$idCar = $_GET['idCar'];
		if (isset($_GET['vinCar']) && isset($_GET['idModel'])
			&& isset($_GET['bodyType']) && isset($_GET['power'])
			&& isset($_GET['cylinderCapacity']) && isset($_GET['fuel'])
			&& isset($_GET['transmission']) && isset($_GET['driveType'])
			&& isset($_GET['color']) && isset($_GET['year'])
			&& isset($_GET['registrationNumber'])) {
			$database->editCar($_GET);
		}


		$sql = <<<_END
	SELECT * FROM Cars 
	WHERE idCar=$idCar
_END;
		$result = $database->database->query($sql);
		$values = $result->fetchArray(SQLITE3_ASSOC);
		$vinCar = ($values['vinCar']);
		$idModel = ($values['idModel']);
		$bodyType = ($values['bodyType']);
		$power = ($values['power']);
		$cylinderCapacity = ($values['cylinderCapacity']);
		$fuel = ($values['fuel']);
		$transmission = ($values['transmission']);
		$driveType = ($values['driveType']);
		$color = ($values['color']);
		$year = ($values['year']);
		$registrationNumber = ($values['registrationNumber']);

		$maxYear = date("Y");
		$content = <<<_END
			<form method='get' action='car.php'>
			  <input type="hidden" name='idCar' value=$idCar>
		      vinCar:<br>
		      <input type='text' name='vinCar' value=$vinCar><br>
		      bodyType:<br>
		      <input type='text' name='bodyType' value=$bodyType><br>
		      power:<br>
		      <input type='text' name='power' value=$power><br>
		      cylinderCapacity:<br>
		      <input type='text' name='cylinderCapacity' value=$cylinderCapacity><br>
		      fuel:<br>
		      <input type='text' name='fuel' value=$fuel><br>
		      transmission:<br>
		      <input type='text' name='transmission' value=$transmission><br>
		      driveType:<br>
		      <input type='text' name='driveType' value=$driveType><br>
		      color:<br>
		      <input type='text' name='color' value=$color><br>
		      year:<br>
		      <input type='number' name='year' min='1900' max=$maxYear step="1" value=$year><br>
		      registrationNumber:<br>
		      <input type='text' name='registrationNumber' value=$registrationNumber><br>
		      <input type='submit' value='submit'>
		    </form>
_END;
		template($content);

	} else header("Location: cars.php");


	template("");
	var_dump($_GET);
?>