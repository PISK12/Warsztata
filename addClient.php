<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018-07-19
 * Time: 00:32
 */?>

<?php
	require_once "config.php";
    require_once "functions.php";
    require_once "Database.php";
    require_once "template.php";
?>

<?php
	$content= <<<_END
	<form method='get' action='addClient.php'>
      First name:<br>
      <input type='text' name='firstName'><br>
      Last name:<br>
      <input type='text' name='lastName'><br>
      Phone Number:<br>
      <input type='text' name='phoneNumber'><br><br>
      <input type='submit' value='submit'>
    </form>
_END;

if(isset($_GET['firstName'])&&isset($_GET['lastName'])){
    $datebase=new Database($fileNameDatabase);
	$datebase->addNewClient($_GET);
	$id=$datebase->database->lastInsertRowID();
	if(isset($_GET['phoneNumber'])){
		$datebase->addNumber(array_merge($_GET,array('idClient'=>$id)));
	}
    $content="<p>Add New Client</p>".$id.$content;
}
template($content);
?>