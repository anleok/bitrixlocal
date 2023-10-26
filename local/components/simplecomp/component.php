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
	unset($arElement);

	if (is_countable($arClassifierID)) {
		$arResult["CLASSIFIER_COUNT"] = count($arClassifierID);
	}

	// элементы с привязкой с классификатору
    $arSelectElementsProducts = array (
        "ID",
        "NAME",
        "DETAIL_PAGE_URL",
    );
    $arFilterElementsProducts = array (
        "IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
        "CHECK_PERMISSIONS" => $arParams["CACHE_GROUPS"],
        "PROPERTY_".$arParams["PROPERTY_CODE"] => $arClassifierID,
        "ACTIVE" => "Y"
    );

    $rsElements = CIBlockElement::GetList(array(), $arFilterElementsProducts, false, false, $arSelectElementsProducts);

    while($arElement= $rsElements->GetNextElement()) {
        $arElementField = $arElement->GetFields();
        $arElementField["PROPERTIES"] = $arElement->GetProperties();

        foreach ($arElementField["PROPERTIES"][$arParams["PROPERTY_CODE"]]["VALUE"] as $value) {
            $arClassifier[$value]["ELEMENTS"][$arElementField["ID"]] = $arElementField;
        }
    }

	$arResult["CLASSIFIER"] = $arClassifier;

	unset($arElement);
	unset($arElementField);
	unset($arClassifier);
	unset($arClassifierID);

    $this->SetResultCacheKeys(array("CLASSIFIER_COUNT"));
    $this->includeComponentTemplate();
}

$APPLICATION->SetTitle(GetMessage("SIMPLECOMP_EXAM2_CLASSIFIER_COUNT") . $arResult["CLASSIFIER_COUNT"]);
?>