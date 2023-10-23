<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Форма обратной связи");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"",
	Array(
		"EMAIL_TO" => "al.okorokova@mail.ru",
		"EVENT_MESSAGE_ID" => array(),
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"REQUIRED_FIELDS" => array("NAME","EMAIL","MESSAGE"),
		"USE_CAPTCHA" => "Y"
	)
);?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>