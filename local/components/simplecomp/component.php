<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (empty($arParams["PRODUCTS_IBLOCK_ID"])) {
    $arParams["PRODUCTS_IBLOCK_ID"] = 0;
}

if (empty($arParams["CLASSIFIER_IBLOCK_ID"])) {
	$arParams["SCLASSIFIER_IBLOCK_ID"] = 0;
}

if (!isset($arParams["CACHE_TIME"]))
{
	$arParams["CACHE_TIME"] = 36000000;
}

$arParams["PRODUCTS_IBLOCK_ID"] = trim($arParams["PRODUCTS_IBLOCK_ID"] ?? '');
$arParams["CLASSIFIER_IBLOCK_ID"] = trim($arParams["CLASSIFIER_IBLOCK_ID"] ?? '');
$arParams["PROPERTY_CODE"] = trim($arParams["PROPERTY_CODE"] ?? '');

echo '<pre>' . print_r( $arParams, true ) . '</pre>';
global $USER;
if($this->startResultCache(false, array(($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))){
	// классификаторы
	$arResult["CLASSIFIER_COUNT"] = 0;
	$arSelectElements = array(
        "ID",
        "NAME"
    );
    $arFilterElements = array(
		"IBLOCK_ID" => $arParams["CLASSIFIER_IBLOCK_ID"],
        "ACTIVE" => "Y",
        "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"]
    );

    $rsElements = CIBlockElement::GetList(array(), $arFilterElements, false, false, $arSelectElements);

    while($arElement = $rsElements->GetNext()) {
        $arClassifier[$arElement["ID"]] = $arElement;
        $arClassifierID[] = $arElement["ID"];
    }

	if (is_countable($arClassifierID)) {
		$arResult["CLASSIFIER_COUNT"] = count($arClassifierID);
	}
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