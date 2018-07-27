<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 2018-07-26
	 * Time: 01:25
	 */
?>


<?php
	require_once "config.php";
	require_once "Database.php";
	require_once "template.php";
?>


<?php
	function getRow($table)
	{
		$html = "";
		$html = $html . "<tr>";
		$html = $html . "<td><a href=" . "car.php?idCar=" . $table['idCar'] . ">" . $table['idCar'] . "</a></td>";
		$html = $html . "<td><a href=" . "client.php?idClient=" . $table['idClient'] . ">" . $table['idClient'] . "</a></td>";
		$html = $html . "<td>" . $table['title'] . "</td>";
		$html = $html . "<td>" . $table['createDate'] . "</td>";
		$html = $html . "<td>" . $table['comments'] . "</td>";
		$html = $html . "<td>" . $table['preference'] . "</td>";
		$html = $html . "<td>" . $table['price'] . "</td>";
		$html = $html . "</tr>";
		return $html;
	}

	$database = new Database($fileNameDatabase);
	$html = "";

	$results = $database->getAllDiary();
	while ($table = $results->fetchArray(SQLITE3_ASSOC)) {
		$html = $html . getRow($table);

	};

	$content = <<<_END
	<table>
		<tr>
			<th>idCar</th>
			<th>idClient</th>
			<th>title</th>
			<th>createDate</th>
			<th>comments</th>
			<th>preference</th>
			<th>price</th>
		</tr>
		$html
	</table>
_END;
	template($content);
?>
