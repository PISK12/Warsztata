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
	$database=new Database($fileNameDatabase);
	$html="";
	$results=$database->getAllInformationAboutClients();
	while ($table = $results->fetchArray(SQLITE3_ASSOC)) {
		$html=$html."<tr>";
		$html=$html."<td>".$table['idClient']."</td>";
		$html=$html."<td>".$table['firstName']."</td>";
		$html=$html."<td>".$table['lastName']."</td>";
		$html=$html."<td>".$table['phoneNumberClient']."</td>";
		$html=$html."<td><a href="."client.php?idClient=".$table['idClient'].">GO"."</a></td>";
		$html=$html."</tr>";
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