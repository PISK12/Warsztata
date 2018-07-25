<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 2018-07-24
	 * Time: 13:06
	 */?>

<?php
	require_once "config.php";
	require_once "functions.php";
	require_once "Database.php";
	require_once "template.php";
?>


<?php
	if(isset($_GET['idClient'])){
		$idClient=$_GET['idClient'];
	}else $idClient='';
	$maxYear=date("Y");


	$content= <<<_END
	<form method='get' action='addCar.php'>
	  idClient:<br>
      <input type='text' name='idClient' value=$idClient><br>
      vinCar:<br>
      <input type='text' name='vinCar' value=""><br>
      bodyType:<br>
      <input type='text' name='bodyType' value=""><br>
      power:<br>
      <input type='text' name='power' value=""><br>
      cylinderCapacity:<br>
      <input type='text' name='cylinderCapacity' value=""><br>
      fuel:<br>
      <input type='text' name='fuel' value=""><br>
      transmission:<br>
      <input type='text' name='transmission' value=""><br>
      driveType:<br>
      <input type='text' name='driveType' value=""><br>
      color:<br>
      <input type='text' name='color' value=""><br>
      year:<br>
      <input type='number' name='year' min='1900' max=$maxYear step="1" value="2014"><br>
      registrationNumber:<br>
      <input type='text' name='registrationNumber' value=""><br>
      <input type='submit' value='submit'>
    </form>
_END;

	template($content);

?>
