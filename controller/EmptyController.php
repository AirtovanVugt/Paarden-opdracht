<?php

require(ROOT . "model/EmptyModel.php");


function index(){
	$Horses = getAllHorses();
    render('empty/index', array('Horses' => $Horses));
}

function TussenLogin(){
	$Person = GetPerson($Id);
	render("empty/TussenLogin", array("Person" => $Person));
}

function Inloggen(){
	render("empty/Inloggen");
}

function CreateAccountPaige(){
	$People = getAllPeople();
	render("empty/CreateAccount", array("People" => $People));
}

function CreateAccount(){
	$Name = ExistName($_POST);
	$Email = ExistEmail($_POST);
	$Password = ExistPassword($_POST);
	if(empty($_POST["NamePerson"]) || empty($_POST["Mail"]) || empty($_POST["Password"])){
		$EmptyText = "Niet alle velden zijn ingevuld.";
		render("empty/CreateAccount", array("EmptyText" => $EmptyText));
	}
	elseif(strtolower($_POST["NamePerson"]) == strtolower($Name["NamePerson"]) || strtolower($_POST["Mail"]) == strtolower($Email["Email"]) || strtolower($_POST["Password"]) == strtolower($password["Password"])){
		if(strtolower($_POST["NamePerson"]) == strtolower($Name["NamePerson"])){
			$UsedName = "Deze naam is al in gebruik.";
		}
		if(strtolower($_POST["Mail"]) == strtolower($Email["Email"])){
			$UsedEmail = "Deze Email is al in gebruik.";
		}
		if(strtolower($_POST["Password"]) == strtolower($Password["Password"])){
			$UsedPassword = "Deze Wachtwoord is al in gebruik.";
		}
		render("empty/CreateAccount", array("UsedName" => $UsedName, "UsedEmail" => $UsedEmail, "UsedPassword" => $UsedPassword));
	}
	else{
	    CreateAccountPerson($_POST);
	    header("Location: ".URL);
	}
}

function LoggingIn(){
	$Person = GetOnePerson($_POST);
	if(empty($_POST["Mail"]) || empty($_POST["Password"])){
		$EmptyText = "Niet alle velden zijn ingevuld.";
		render("empty/Inloggen", array("EmptyText" => $EmptyText));
	}
	elseif($Person == false){
		$EmptyText = "Dit account bestaat niet.";
		render("empty/Inloggen", array("EmptyText" => $EmptyText));
	}
	elseif($_POST["Mail"] != $Person["Email"] || $_POST["Password"] != $Person["Password"]){
		$EmptyText = "Dit account bestaat niet.";
		render("empty/Inloggen", array("EmptyText" => $EmptyText));
	}
	else{
		$Horses = getAllHorses();
		render('empty/index', array('Horses' => $Horses, 'Person' => $Person));
	}
}

function GetOneHorse($id, $Person){
	$Person = GetPerson($Person);
    $Horse = GetHorse($id);
    $JavaJuse = JavaJuses($Horse["HorseName"]);
    render("empty/PaardHuren", array("Horse" => $Horse, "Person" => $Person, "JavaJuse" => $JavaJuse));
}

function HorseHire(){
	if($_POST["deDag"] == "Kies je dag" || $_POST["deTijd"] == "Kies je tijd"){
		$Person = GetPerson($_POST["IdPerson"]);
	    $Horse = GetHorse($_POST["IdHorse"]);
	    $JavaJuse = JavaJuses($Horse["HorseName"]);
		$WrongWorth = "Verkeerde waarde ingevoerd";
		render("empty/PaardHuren", array("WrongWorth" => $WrongWorth, "Person" => $Person, "Horse" => $Horse, "JavaJuse" => $JavaJuse));
	}
	else{
		CreateHire($_POST);
		$Person = GetPerson($_POST["IdPerson"]);
		$Horses = getAllHorses();
		render("empty/index", array("Horses" => $Horses, "Person" => $Person));
	}

}

function HorseChange(){
	$Horses = getAllHorses();
	$HiresThisWeek = GetAllHiresThisWeek();
	$HiresNextWeek = GetAllHiresNextWeek();
	$Person = GetPerson($_POST["IdPerson"]);
	render("empty/GehuurdePaardVeranderen", array("HiresThisWeek" => $HiresThisWeek, "HiresNextWeek" => $HiresNextWeek, "Horses" => $Horses, "Person" => $Person));
}