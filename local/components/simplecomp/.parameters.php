<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_PRODUCTS_IBLOCK_ID"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"CLASSIFIER_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CLASSIFIER_IBLOCK_ID"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"DETAIL_PAGE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_DETAIL_PAGE"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"PROPERTY_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_PROPERTY_CODE"),
			"PARENT" => "BASE",
			"TYPE" => "STRING",
		),
		"CACHE_TIME"  =>  ["DEFAULT"=>36000000],
		"CACHE_GROUPS" => [
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		],
	),
);