BEGIN TRANSACTION;
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
  `title`	TEXT NOT NULL,
  `createDate`	NUMERIC NOT NULL,
  `status`	TEXT NOT NULL,
  `comment`	TEXT,
  `preference`	TEXT,
  `price`	INTEGER
);

CREATE TABLE IF NOT EXISTS `Diary_Client` (
  `idDiary` INTEGER NOT NULL,
  `idClient`	INTEGER NOT NULL,
  FOREIGN KEY(`idDiary`) REFERENCES `Diary`(`idDiary`),
  FOREIGN KEY(`idClient`) REFERENCES `Clients`(`idClient`)
);
CREATE TABLE IF NOT EXISTS `Diary_Car` (
  `idDiary` INTEGER NOT NULL,
  `idCar`	INTEGER NOT NULL,
  FOREIGN KEY(`idDiary`) REFERENCES `Diary`(`idDiary`),
  FOREIGN KEY(`idCar`) REFERENCES `Cars`(`idCar`)
);

COMMIT;
