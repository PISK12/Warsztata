<?php
/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018-07-19
 * Time: 00:33
 */
?>

<?php
	require_once "config.php";
	require_once "Database.php";
	require_once "vendor/fzaninotto/faker/src/autoload.php";
?>


<?php
	function fillFakeNumbers($howMany=0,$datebase){
		$faker=Faker\Factory::create();
		$results=$datebase->getAllClient();
		$arrayWithIdClients=array();
		while ($table = $results->fetchArray(SQLITE3_ASSOC)){
			$arrayWithIdClients[]=$table['idClient'];
		}

		if($howMany){
			$rand_keys = array_rand($arrayWithIdClients, $howMany+1);
			for(;$howMany;$howMany--){
				$datebase->addNumber(array(
					'idClient'=>$arrayWithIdClients[$rand_keys[$howMany]],
					'phoneNumber'=>$faker->phoneNumber));
			}
		}else{
			foreach ($arrayWithIdClients as $idClient){
				$datebase->addNumber(array(
					'idClient'=>$idClient,'phoneNumber'=>$faker->phoneNumber));
			}
		}

	}

	function fillFakeClients($howMany,$datebase){
		$faker=Faker\Factory::create();
		for(;$howMany;$howMany--){
			$name=$faker->firstName;
			$lastName=$faker->lastName;
			$datebase->addNewClient(array("firstName"=>$name,"lastName"=>$lastName));
		}
	}

	function fillFakeCarModel($howMany=0,$whichIdBrand=0,$database){
		$faker=Faker\Factory::create();
		$allIdBrands=[];
		if(!$whichIdBrand){
			$sql="SELECT * FROM CarBrands";
			$result=$database->database->query($sql);
			while ($table = $result->fetchArray(SQLITE3_ASSOC)) {
				$allIdBrands[]=$table['idBrand'];
			}
		}else $allIdBrands[]=$whichIdBrand;
		$orginHowMany=$howMany;
		foreach ($allIdBrands as $id){
			if(!$howMany){
				$model=$faker->word;
				$database->addNewModel($model,$id);
			}else{
				for(;$howMany;$howMany--){
					$model=$faker->firstNameFemale;
					$database->addNewModel($model,$id);
				}
				$howMany=rand(1,$orginHowMany);
			}
		}
	}

	function fillFakeCars($database){
		$result=$database->database->query("SELECT count(*) as total from Clients");
		$data=$result->fetchArray(SQLITE3_ASSOC);
		$howManyClients=$data["total"];

		$idModels=[];
		$sql="SELECT * FROM CarModels";
		$result=$database->database->query($sql);
		while ($table = $result->fetchArray(SQLITE3_ASSOC)) {
			$idModels[]=$table['idModel'];
		}
		$bodyTypes=array("SUV","coupe","dual cowl",
			"fastback","hatchback","kabriolet","kombi",
			"liftback","limuzyna","mikrovan","minivan",
			"pick-up","roadster","sedan","targa",
			"van");
		for(;$howManyClients;$howManyClients--){
			$vimCar=rand(pow(10,16),pow(10,17)-1);
			$idModel=$idModels[array_rand($idModels,1)];
			$bodyType=$bodyTypes[rand(0,count($bodyTypes)-1)];
			$power=rand(60,200);
			$cylinderCapacity=rand(10,50)*100;
			$fuel="gaz";
			$transmission="manual";
			$driveType="tył";
			$color="biały";
			$year=rand(1995,2018);
			$registrationNumber="WI".rand(1000,9999);
			$values=array("vimCar"=>$vimCar,"idModel"=>$idModel,
				"bodyType"=>$bodyType,"power"=>$power,"cylinderCapacity"=>$cylinderCapacity,
				"fuel"=>$fuel,"transmission"=>$transmission,"driveType"=>$driveType,
				"color"=>$color,"year"=>$year,"registrationNumber"=>$registrationNumber);
			$database->addCar($values);
		}
	}

	function fillFakeClient_Car($database){
		fillFakeCars($database);

		$sql='SELECT idClient FROM Clients';
		$allIdCilents=[];
		$result=$database->database->query($sql);
		while ($table = $result->fetchArray(SQLITE3_ASSOC)) {
			$allIdCilents[]=$table['idClient'];
		}

		$sql='SELECT idCar FROM Cars';
		$allIdCars=[];
		$result=$database->database->query($sql);
		while ($table = $result->fetchArray(SQLITE3_ASSOC)) {
			$allIdCars[]=$table['idCar'];
		}

		foreach ($allIdCilents as $idCilent){
			$database->connectClient_Car(array("idClient"=>$idCilent,"idCar"=>array_pop($allIdCars)));
		}

		foreach ($allIdCars as $idCar){
			$idCilent=$allIdCilents[array_rand($allIdCilents,1)];
			$database->connectClient_Car(array("idClient"=>$idCilent,"idCar"=>$idCar));
		}

	}

?>