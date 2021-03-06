<?php /** @noinspection ALL */
	/**
 * Created by PhpStorm.
 * User: Dell
 * Date: 2018-07-22
 * Time: 14:38
 */

require_once "vendor/fzaninotto/faker/src/autoload.php";

class Database{
	public function __construct($filename){
		$this->database=new SQLite3($filename);
		$this->database->exec("BEGIN TRANSACTION");
		$sql=<<<_END
	CREATE TABLE IF NOT EXISTS `Clients` (
	  `idClient`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	  `firstName`	TEXT NOT NULL,
	  `lastName`	TEXT NOT NULL
	);
	
	CREATE TABLE IF NOT EXISTS `PhoneNumberClients` (
	  `idPhoneNumberClient`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	  `phoneNumberClient`	TEXT NOT NULL,
	  `idClient` INTEGER NOT NULL,
	  FOREIGN KEY(`idClient`) REFERENCES `Clients`(`idClient`)
	);
	
	CREATE TABLE IF NOT EXISTS `CarBrands` (
	  `idBrand` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	  `brand`	TEXT NOT NULL UNIQUE
	);
	
	CREATE TABLE IF NOT EXISTS `CarModels` (
	  `idModel`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	  `idBrand`	INTEGER NOT NULL,
	  `model`	TEXT NOT NULL,
	  FOREIGN KEY(`idBrand`) REFERENCES `CarBrands`(`idBrand`)
	);
	
	CREATE TABLE IF NOT EXISTS `Cars` (
	  `idCar`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	  `vinCar`	TEXT,
	  `idModel`	INTEGER NOT NULL,
	  `bodyType`	TEXT,
	  `power`	TEXT,
	  `cylinderCapacity`	TEXT,
	  `fuel`	TEXT,
	  `transmission`	TEXT,
	  `driveType`	TEXT,
	  `color`	TEXT,
	  `year`	INTEGER NOT NULL,
	  `registrationNumber`	TEXT,
	  FOREIGN KEY(`idModel`) REFERENCES `CarModels`(`idModel`)
	);
	
	CREATE TABLE IF NOT EXISTS `Client_Car` (
	  `idClient`	INTEGER NOT NULL,
	  `idCar`	INTEGER NOT NULL,
	  FOREIGN KEY(`idClient`) REFERENCES `Clients`(`idClient`),
	  FOREIGN KEY(`idCar`) REFERENCES `Cars`(`idCar`)
	);
	
	CREATE TABLE IF NOT EXISTS `Diary` (
	  `idDiary`	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	  `idCar`	INTEGER NOT NULL,
	  `idClient`	INTEGER NOT NULL,
	  `title`	TEXT NOT NULL,
	  `createDate`	NUMERIC NOT NULL,
	  `status`	TEXT NOT NULL,
	  `comments`	TEXT,
	  `preference`	TEXT,
	  `price`	INTEGER,
	  FOREIGN KEY(`idClient`) REFERENCES `Clients`(`idClient`),
	  FOREIGN KEY(`idCar`) REFERENCES `Cars`(`idCar`)
	);
_END;

		$this->database->exec($sql);
		$this->database->exec("COMMIT");
	}

	private function sqlite_fix_string($string){
		if(get_magic_quotes_gpc()) $string=stripslashes($string);
		if (is_string($string)) {
			$string = trim($string);
			return $this->database->escapeString($string);
		} else return $string;
	}

	public function addNewClient($values){
		$firstName=$this->sqlite_fix_string($values['firstName']);
		$lastName=$this->sqlite_fix_string($values['lastName']);
		$sql='INSERT INTO  Clients(firstName,lastName) VALUES(?,?)';
		$stmt=$this->database->prepare($sql);
		$stmt->bindParam(1,$firstName);
		$stmt->bindParam(2,$lastName);
		$stmt->execute();
		$stmt->close();
	}

	public function addNumber($values){
		$idClient=$this->sqlite_fix_string($values['idClient']);
		$number=$this->sqlite_fix_string($values['phoneNumber']);
		$sql='INSERT INTO PhoneNumberClients(phoneNumberClient,idClient) VALUES(?,?)';
		$stmt=$this->database->prepare($sql);
		$stmt->bindParam(1,$number);
		$stmt->bindParam(2,$idClient);
		$stmt->execute();
		$stmt->close();
	}

	public function addNewCarBrand($values){
		$values=$this->sqlite_fix_string($values);
		$sql='INSERT INTO CarBrands(brand) VALUES(?)';
		$stmt=$this->database->prepare($sql);
		$stmt->bindParam(1,$values);
		$stmt->execute();
		$stmt->close();
	}

	public function addNewModel($model,$idBrand){
		$model=$this->sqlite_fix_string($model);
		$idBrand=$this->sqlite_fix_string($idBrand);
		$sql='INSERT INTO CarModels(model,idBrand) VALUES(?,?)';
		$stmt=$this->database->prepare($sql);
		$stmt->bindParam(1,$model);
		$stmt->bindParam(2,$idBrand);
		$stmt->execute();
		$stmt->close();
	}

	public function addCar($values){
		$vimCar=$this->sqlite_fix_string($values['vimCar']);
		$idModel = $this->sqlite_fix_string($values['idModel']);
		$bodyType=$this->sqlite_fix_string($values['bodyType']);
		$power=$this->sqlite_fix_string($values['power']);
		$cylinderCapacity=$this->sqlite_fix_string($values['cylinderCapacity']);
		$fuel=$this->sqlite_fix_string($values['fuel']);
		$transmission=$this->sqlite_fix_string($values['transmission']);
		$driveType=$this->sqlite_fix_string($values['driveType']);
		$color=$this->sqlite_fix_string($values['color']);
		$year=$this->sqlite_fix_string($values['year']);
		$registrationNumber=$this->sqlite_fix_string($values['registrationNumber']);
		$sql=<<<_END
		INSERT INTO Cars(vinCar,idModel,
			bodyType,power,cylinderCapacity,
			fuel,transmission,driveType,
			color,year,registrationNumber) VALUES(?,?,?,?,?,?,?,?,?,?,?)
_END;
		$stmt=$this->database->prepare($sql);
		$stmt->bindParam(1,$vimCar);
		$stmt->bindParam(2, $idModel);
		$stmt->bindParam(3,$bodyType);
		$stmt->bindParam(4,$power);
		$stmt->bindParam(5,$cylinderCapacity);
		$stmt->bindParam(6,$fuel);
		$stmt->bindParam(7,$transmission);
		$stmt->bindParam(8,$driveType);
		$stmt->bindParam(9,$color);
		$stmt->bindParam(10,$year);
		$stmt->bindParam(11,$registrationNumber);
		$stmt->execute();
		$stmt->close();
	}

	public function addDiary($values)
	{
		$idCar = $this->sqlite_fix_string($values['idCar']);
		$idClient = $this->sqlite_fix_string($values['idClient']);
		$title = $this->sqlite_fix_string($values['title']);
		$createDate = $this->sqlite_fix_string($values['createDate']);
		$status = $this->sqlite_fix_string($values['status']);
		$comment = $this->sqlite_fix_string($values['comments']);
		$preference = $this->sqlite_fix_string($values['preference']);
		$price = $this->sqlite_fix_string($values['price']);
		$sql = <<<_END
		INSERT INTO Diary(idCar,idClient,
			title,createDate,status,
			comments,preference,price) 
			VALUES(?,?,?,?,?,?,?,?)
_END;
		$stmt = $this->database->prepare($sql);
		$stmt->bindParam(1, $idCar);
		$stmt->bindParam(2, $idClient);
		$stmt->bindParam(3, $title);
		$stmt->bindParam(4, $createDate);
		$stmt->bindParam(5, $status);
		$stmt->bindParam(6, $comments);
		$stmt->bindParam(7, $preference);
		$stmt->bindParam(8, $price);
		$stmt->execute();
		$stmt->close();
	}

	public function editCar($values)
	{
		$idCar = $this->sqlite_fix_string($values['idCar']);
		$vinCar = $this->sqlite_fix_string($values['vinCar']);
		$idModel = $this->sqlite_fix_string($values['idModel']);
		$bodyType = $this->sqlite_fix_string($values['bodyType']);
		$power = $this->sqlite_fix_string($values['power']);
		$cylinderCapacity = $this->sqlite_fix_string($values['cylinderCapacity']);
		$fuel = $this->sqlite_fix_string($values['fuel']);
		$transmission = $this->sqlite_fix_string($values['transmission']);
		$driveType = $this->sqlite_fix_string($values['driveType']);
		$color = $this->sqlite_fix_string($values['color']);
		$year = $this->sqlite_fix_string($values['year']);
		$registrationNumber = $this->sqlite_fix_string($values['registrationNumber']);
		$sql = <<<_END
		UPDATE Cars 
		SET 
			vinCar=$vinCar,
			idModel=$idModel,
			bodyType=,
			power=,
			cylinderCapacity=,
			fuel=,
			transmission=,
			driveType=,
			color=,
			year=,
			registrationNumber= 
		WHERE idCar=$idCar
_END;
		$stmt = $this->database->prepare($sql);
		$stmt->bindParam(1, $vimCar);
		$stmt->bindParam(2, $idModel);
		$stmt->bindParam(3, $bodyType);
		$stmt->bindParam(4, $power);
		$stmt->bindParam(5, $cylinderCapacity);
		$stmt->bindParam(6, $fuel);
		$stmt->bindParam(7, $transmission);
		$stmt->bindParam(8, $driveType);
		$stmt->bindParam(9, $color);
		$stmt->bindParam(10, $year);
		$stmt->bindParam(11, $registrationNumber);
		$stmt->execute();
		$stmt->close();
	}

	public function connectClient_Car($values){
		$idClient=$this->sqlite_fix_string($values['idClient']);
		$idCar=$this->sqlite_fix_string($values['idCar']);
		$sql='INSERT INTO Client_Car VALUES(?,?)';
		$stmt=$this->database->prepare($sql);
		$stmt->bindParam(1,$idClient);
		$stmt->bindParam(2,$idCar);
		$stmt->execute();
		$stmt->close();
	}

	public function getAllClient(){
		$sql="SELECT * FROM Clients ORDER BY idClient ASC";
		return $this->database->query($sql);
	}

	public function getInformationAboutAllClients()
	{
		$sql=<<<_END
SELECT Clients.idClient,Clients.firstName,Clients.lastName,PhoneNumberClients.phoneNumberClient 
				FROM Clients 
				LEFT JOIN PhoneNumberClients 
				ON PhoneNumberClients.idClient=Clients.idClient
				ORDER BY Clients.idClient ASC
_END;
		return $this->database->query($sql);
	}

	public function getAllInformationAboutClientByIdClient($values){
			$idClient=$this->sqlite_fix_string($values);
		$sql=<<<_END
SELECT Clients.idClient,Clients.firstName,Clients.lastName,PhoneNumberClients.phoneNumberClient 
				FROM Clients 
				LEFT JOIN PhoneNumberClients 
				ON PhoneNumberClients.idClient=Clients.idClient
				WHERE Clients.idClient=$idClient
_END;
		return $this->database->query($sql);
	}

	public function getAllModelsAndBrands(){
		$sql="SELECT brand,model FROM CarModels LEFT JOIN CarBrands ON CarModels.idBrand=CarBrands.idBrand;";
	}

	public function getAllInformationAboutCarByIdClient($values)
	{
		$idClient = $this->sqlite_fix_string($values);
		$sql = <<<_END
			SELECT * FROM Clients 
			LEFT OUTER JOIN Client_Car ON (Clients.idClient=Client_Car.idClient) 
			INNER JOIN Cars ON (Client_Car.idCar=Cars.idCar) 
			WHERE Clients.idClient=$idClient
_END;

		return $this->database->query($sql);
	}

	public function getModelByIdModel($idModel)
	{
		$sql = <<<_END
		SELECT model 
		FROM CarModels 
		WHERE idModel=$idModel
_END;
		$result = $this->database->query($sql);
		return $result->fetchArray(SQLITE3_ASSOC)['model'];
	}

	public function getBrandByIdModel($idModel)
	{
		$sql = <<<_END
 		SELECT CarBrands.brand FROM CarModels 
 		INNER JOIN CarBrands ON (CarBrands.idBrand=CarModels.idBrand)
		WHERE idModel=$idModel
_END;
		$result = $this->database->query($sql);
		return $result->fetchArray(SQLITE3_ASSOC)['brand'];
	}

	public function getAllDiary()
	{
		$sql = 'SELECT * FROM Diary ORDER BY createDate DESC';
		return $this->database->query($sql);
	}

	public function getAllDiaryByIdClient($values)
	{
		$idClient = $this->sqlite_fix_string($values['idClient']);
		$sql = <<<_END
		SELECT * FROM 
		Diary WHERE idClient=$idClient 
		ORDER BY createDate DESC
_END;
		return $this->database->query($sql);
	}
}

