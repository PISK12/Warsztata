<?php
	/**
	 * Created by PhpStorm.
	 * User: Dell
	 * Date: 2018-07-23
	 * Time: 01:19
	 */
	?>


<?php
	require_once "config.php";
	require_once "Database.php";
	require_once "template.php";
?>

<?php
	$content=<<<_END
	<form method='get' action='client.php'>
	  Search:<br>
      <input type='text' name='query'><br><br>
      <input type='submit' value='submit'>
    </form>
_END;
	template($content);
?>
