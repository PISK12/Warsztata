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
	function getRow($table, $database)
	{
		$idCar = $table['idCar'];
		$sql = <<<_END
		SELECT idModel FROM cars 
		WHERE idCar=$idCar
_END;

		$result = $database->database->query($sql);
		$data = $result->fetchArray(SQLITE3_ASSOC);
		$table['idModel'] = $data['idModel'];
		$html = "";
		$html = $html . "<tr>";
		$html = $html . "<td><a href=" . "car.php?idCar=" . $table['idCar'] . ">" . $table['idCar'] . "</a></td>";
		$html = $html . "<td>" . $database->getBrandByIdModel($table['idModel']) . "</td>";
		$html = $html . "<td>" . $database->getModelByIdModel($table['idModel']) . "</td>";
		$html = $html . "<td>" . $table['title'] . "</td>";
		$html = $html . "<td>" . $table['createDate'] . "</td>";
		$html = $html . "<td>" . $table['comments'] . "</td>";
		$html = $html . "<td>" . $table['preference'] . "</td>";
		$html = $html . "<td>" . $table['price'] . "</td>";
		$html = $html . "</tr>";
		return $html;
	}

	if (isset($_GET['idClient'])) {
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
		}
		$content = $content . "<a href=" . "addCar.php?idClient=" . $table['idClient'] . ">Add Car" . "</a>";


		$content = $content = $content . "<br><br>";
		$results = $database->getAllInformationAboutCarByIdClient($_GET['idClient']);
		while ($table = $results->fetchArray(SQLITE3_ASSOC)) {
			$content = $content . "<br>";
			$content = $content . "<p>" . 'Brand' . ": " . $database->getBrandByIdModel($table['idModel']) . "</p>";
			$content = $content . "<p>" . 'Model' . ": " . $database->getModelByIdModel($table['idModel']) . "</p>";
			$content = $content . "<p>" . 'vinCar' . ": " . $table['vinCar'] . "</p>";
			$content = $content . "<p>" . 'bodyType' . ": " . $table['bodyType'] . "</p>";
			$content = $content . "<p>" . 'power' . ": " . $table['power'] . "</p>";
			$content = $content . "<p>" . 'cylinderCapacity' . ": " . $table['cylinderCapacity'] . "</p>";
			$content = $content . "<p>" . 'fuel' . ": " . $table['fuel'] . "</p>";
			$content = $content . "<p>" . 'transmission' . ": " . $table['transmission'] . "</p>";
			$content = $content . "<p>" . 'driveType' . ": " . $table['driveType'] . "</p>";
			$content = $content . "<p>" . 'color' . ": " . $table['color'] . "</p>";
			$content = $content . "<p>" . 'year' . ": " . $table['year'] . "</p>";

			$content = $content . "<p>" . 'registrationNumber' . ": " . $table['registrationNumber'] . "</p>";
			$content = $content . "<a href=" . "car.php?idCar=" . $table['idCar'] . ">Edit Car" . "</a>";

		}

		$results = $database->getAllDiaryByIdClient($_GET);
		$html = "";
		while ($table = $results->fetchArray(SQLITE3_ASSOC)) {
			$html = $html . getRow($table, $database);
		}

		$content = $content . <<<_END
	<table>
		<tr>
			<th>idCar</th>
			<th>Brand</th>
			<th>Model</th>
			<th>title</th>
			<th>createDate</th>
			<th>comments</th>
			<th>preference</th>
			<th>price</th>
		</tr>
		$html
	</table>
_END;


	}
	template($content);
?>
