<!--check connection -->

<?php
	function checkConnection(){
	    try{ 
    		$conn = openDatabaseConnection(); 
	       	$stmt = $conn->prepare("SHOW TABLES");
       		$stmt->execute();
       		$stmt->fetchAll();
       		
	    }catch(Exception $e){
			return false;
	    }

	    return true;
	}

?>

<!-- Select Everything -->

<?php

function getAllHorses(){
  // Met het try statement kunnen we code proberen uit te voeren. Wanneer deze
  // mislukt kunnen we de foutmelding afvangen en eventueel de gebruiker een
  // nette foutmelding laten zien. In het catch statement wordt de fout afgevangen
   try {
       // Open de verbinding met de database
       $conn=openDatabaseConnection();
   
       // Zet de query klaar door middel van de prepare method
       $stmt = $conn->prepare("SELECT * FROM horses");

       // Voer de query uit
       $stmt->execute();

       // Haal alle resultaten op en maak deze op in een array
       // In dit geval is het mogelijk dat we meedere medewerkers ophalen, daarom gebruiken we
       // hier de fetchAll functie.
       $result = $stmt->fetchAll();

   }
   // Vang de foutmelding af
   catch(PDOException $e){
       // Zet de foutmelding op het scherm
       echo "Connection failed: " . $e->getMessage();
   }

   // Maak de database verbinding leeg. Dit zorgt ervoor dat het geheugen
   // van de server opgeschoond blijft
   $conn = null;

   // Geef het resultaat terug aan de controller
   return $result;
}

function getAllPeople(){
    try{
        $conn=openDatabaseConnection();
        $stmt = $conn->prepare("SELECT * FROM people");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
        $conn = null;
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}

function GetAllHiresThisWeek(){
    try{
        $conn=openDatabaseConnection();
        $stmt = $conn->prepare("SELECT * FROM hire WHERE Week = 'DezeWeek'");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
        $conn = null;
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}

function GetAllHiresNextWeek(){
    try{
        $conn=openDatabaseConnection();
        $stmt = $conn->prepare("SELECT * FROM hire WHERE Week = 'VolgendeWeek'");
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
        $conn = null;
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}

function JavaJuses($data){
    try{
        $conn=openDatabaseConnection();
        $stmt = $conn->prepare("SELECT * FROM hire WHERE NameHorse = :TheHorse AND Week = 'VolgendeWeek'");
        $stmt->bindParam(":TheHorse", $data);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
        $conn = null;
    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}

?>

<!-- Get one thing -->

<?php

function GetHorse($id){
    try{
        $conn=openDatabaseConnection();
        $stmt = $conn->prepare("SELECT * FROM horses WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
        $conn = null;

    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}

function GetPerson($id){
    try{
        $conn=openDatabaseConnection();
        $stmt = $conn->prepare("SELECT * FROM People WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
        $conn = null;

    }
    catch(PDOException $e){
        echo "Connection failed: " . $e->getMessage();
    }
}

?>

<!-- Insert Into -->

<?php

function CreateAccountPerson($data){
    try{
        $conn = openDatabaseConnection();
        $query = $conn->prepare("INSERT INTO People (NamePerson, Email, Password, Host) VALUES (:Naam, :Mail, :Wachtwoord, 'NoHost')");
        $query->execute([":Naam" => $data["NamePerson"], ":Mail" => $data["Mail"], ":Wachtwoord" => $data["Password"]]);
        $conn = null;
    }
    catch(PDOException $e){
        echo "de database error: " . $e->getMessage();
    }
}

function CreateHire($data){
    try{
        $conn = openDatabaseConnection();
        $query = $conn->prepare("INSERT INTO hire (NamePerson, NameHorse, Day, TheTime, Week) VALUES (:NamePerson, :NameHorse, :deDag, :deTijd, 'VolgendeWeek')");
        $query->execute([":NamePerson" => $data["NamePerson"], ":NameHorse" => $data["NameHorse"], ":deDag" => $data["deDag"], ":deTijd" => $data["deTijd"]]);
        $conn = null;
    }
    catch(PDOException $e){
        echo "de database error: " . $e->getMessage();
    }
}

?>

<!-- SELECT AND -->

<?php

function GetOnePerson($data){
    try{
        $conn = openDatabaseConnection();
        $query = $conn->prepare("SELECT * FROM People WHERE Email = :Mail AND Password = :Wachtwoord");
        $query->execute([":Mail" => $data["Mail"], ":Wachtwoord" => $data["Password"]]);
        $result = $query->fetch();
        $conn = null;
        return $result;

    }
    catch(PDOException $e){
        echo "de database error: " . $e->getMessage();
    }
}

?>

<!-- select for duplicates -->

<?php

function ExistName($data){
    try{
        $conn = openDatabaseConnection();
        $query = $conn->prepare("SELECT NamePerson FROM People WHERE NamePerson = :Name");
        $query->execute([":Name" => $data["NamePerson"]]);
        $ExistPerson = $query->fetch();
        $conn = null;
        return $ExistPerson;
    }
    catch(PDOException $e){
        echo "de database error: " . $e->getMessage();
    }
}

function ExistEmail($data){
    try{
        $conn = openDatabaseConnection();
        $query = $conn->prepare("SELECT Email FROM People WHERE Email = :Mail");
        $query->execute([":Mail" => $data["Mail"]]);
        $ExistE = $query->fetch();
        $conn = null;
        return $ExistE;
    }
    catch(PDOException $e){
        echo "de database error: " . $e->getMessage();
    }
}

function ExistPassword($data){
    try{
        $conn = openDatabaseConnection();
        $query = $conn->prepare("SELECT Password FROM People WHERE Password = :Password");
        $query->execute([":Password" => $data["Password"]]);
        $ExistPas = $query->fetch();
        $conn = null;
        return $ExistPas;
    }
    catch(PDOException $e){
        echo "de database error: " . $e->getMessage();
    }
}

?>