<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (empty($arParams["SIMPLECOMP_EXAM2_PRODUCTS_IBLOCK_ID"])) {
    $arParams["SIMPLECOMP_EXAM2_PRODUCTS_IBLOCK_ID"] = 0;
}

if (empty($arParams["SIMPLECOMP_EXAM2_CLASSIFIER_IBLOCK_ID"])) {
	$arParams["SIMPLECOMP_EXAM2_CLASSIFIER_IBLOCK_ID"] = 0;
}

if (!isset($arParams["CACHE_TIME"]))
{
	$arParams["CACHE_TIME"] = 36000000;
}

$arParams["SIMPLECOMP_EXAM2_PRODUCTS_IBLOCK_ID"] = trim($arParams["SIMPLECOMP_EXAM2_PRODUCTS_IBLOCK_ID"] ?? '');
$arParams["SIMPLECOMP_EXAM2_CLASSIFIER_IBLOCK_ID"] = trim($arParams["SIMPLECOMP_EXAM2_CLASSIFIER_IBLOCK_ID"] ?? '');
$arParams["SIMPLECOMP_EXAM2_PROPERTY_CODE"] = trim($arParams["SIMPLECOMP_EXAM2_PROPERTY_CODE"] ?? '');

global $USER;
if($this->startResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))){

}

if(intval($arParams["PRODUCTS_IBLOCK_ID"]) > 0)
{
	
	//iblock elements
	$arSelectElems = array (
		"ID",
		"IBLOCK_ID",
		"NAME",
	);
	$arFilterElems = array (
		"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
		"ACTIVE" => "Y"
	);
	$arSortElems = array (
			"NAME" => "ASC"
	);
	
	$arResult["ELEMENTS"] = array();
	$rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElements->GetNext())
	{
		$arResult["ELEMENTS"][] = $arElement;
	}
	
	//iblock sections
	$arSelectSect = array (
			"ID",
			"IBLOCK_ID",
			"NAME",
	);
	$arFilterSect = array (
			"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
			"ACTIVE" => "Y"
	);
	$arSortSect = array (
			"NAME" => "ASC"
	);
	
	$arResult["SECTIONS"] = array();
	$rsSections = CIBlockSection::GetList($arSortSect, $arFilterSect, false, $arSelectSect, false);
	while($arSection = $rsSections->GetNext())
	{
		$arResult["SECTIONS"][] = $arSection;
	}
		
	// user
	$arOrderUser = array("id");
	$sortOrder = "asc";
	$arFilterUser = array(
		"ACTIVE" => "Y"
	);
	
	$arResult["USERS"] = array();
	$rsUsers = CUser::GetList($arOrderUser, $sortOrder, $arFilterUser); // выбираем пользователей
	while($arUser = $rsUsers->GetNext())
	{
		$arResult["USERS"][] = $arUser;
	}	
	
	
}
$this->includeComponentTemplate();	
?>