<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 2018-07-26
	 * Time: 12:33
	 */ ?>


<?php
	require_once "config.php";
	require_once "Database.php";
	require_once "template.php";
?>


<?php
	function getRow($table, $database)
	{
		$content = "<tr>";
		$content = $content . "<td>" . $database->getBrandByIdModel($table['idModel']) . "</td>";
		$content = $content . "<td>" . $database->getModelByIdModel($table['idModel']) . "</td>";
		$content = $content . "<td>" . $table['vinCar'] . "</td>";
		$content = $content . "<td>" . $table['bodyType'] . "</td>";
		$content = $content . "<td>" . $table['power'] . "</td>";
		$content = $content . "<td>" . $table['cylinderCapacity'] . "</td>";
		$content = $content . "<td>" . $table['fuel'] . "</td>";
		$content = $content . "<td>" . $table['transmission'] . "</td>";
		$content = $content . "<td>" . $table['driveType'] . "</td>";
		$content = $content . "<td>" . $table['color'] . "</td>";
		$content = $content . "<td>" . $table['year'] . "</td>";
		$content = $content . "<td>" . $table['registrationNumber'] . "</td>";
		$content = $content . "</tr>";
		return $content;
	}

	$database = new Database($fileNameDatabase);

	$html = "";
	$results = $database->database->query("SELECT * FROM Cars");

	$guery = "";
	if (isset($_GET['query'])) {
		$guery = strtolower($_GET['query']);
		$guery = trim($guery);
	}
	while ($table = $results->fetchArray(SQLITE3_ASSOC)) {
		$html = $html . getRow($table, $database);
	};

	$content = <<<_END
	<table>
		<tr>
			<th>Brand</th>
			<th>Model</th>
			<th>vinCar</th>
			<th>bodyType</th>
			<th>power</th>
			<th>cylinderCapacity</th>
			<th>fuel</th>
			<th>transmission</th>
			<th>driveType</th>
			<th>color</th>
			<th>year</th>
			<th>registrationNumber</th>
		</tr>
		$html
	</table>
_END;
	template($content);

?>
