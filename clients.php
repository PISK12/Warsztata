<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 2018-07-23
	 * Time: 21:31
	 */?>

<?php
	require_once "config.php";
	require_once "functions.php";
	require_once "Database.php";
	require_once "template.php";
?>

<?php
	function getRow($table)
	{
		$html = "";
		$html = $html . "<tr>";
		$html = $html . "<td>" . $table['idClient'] . "</td>";
		$html = $html . "<td>" . $table['firstName'] . "</td>";
		$html = $html . "<td>" . $table['lastName'] . "</td>";
		$html = $html . "<td>" . $table['phoneNumberClient'] . "</td>";
		$html = $html . "<td><a href=" . "client.php?idClient=" . $table['idClient'] . ">GO" . "</a></td>";
		$html = $html . "</tr>";
		return $html;
	}

	$database=new Database($fileNameDatabase);
	$html="";
	$results = $database->getInformationAboutAllClients();

	$guery = "";
	if (isset($_GET['query'])) {
		$guery = strtolower($_GET['query']);
		$guery = trim($guery);
	}
	while ($table = $results->fetchArray(SQLITE3_ASSOC)) {
		if ($guery) {
			if ($guery == $table['idClient']) {
				$html = $html . getRow($table);
			} elseif ($guery == strtolower($table['firstName'])) {
				$html = $html . getRow($table);
			} elseif ($guery == strtolower($table['lastName'])) {
				$html = $html . getRow($table);
			} elseif ($guery == strtolower($table['firstName'] . " " . $table['lastName'])) {
				$html = $html . getRow($table);
			} elseif ($guery == strtolower($table['lastName'] . " " . $table['firstName'])) {
				$html = $html . getRow($table);
			} elseif ($guery == $table['phoneNumberClient']) {
				$html = $html . getRow($table);
			}
		} else $html = $html . getRow($table);

	};

	$content=<<<_END
	<table>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Last Name</th>
			<th>Phone Number</th>
			<th>More Information</th>
		</tr>
		$html
	</table>
_END;
	template($content);

?>