<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

AddEventHandler('main', 'OnBeforeEventSend', "OnBeforeEventSendHandler");
function OnBeforeEventSendHandler(&$arFields, &$arTemplate)
{
    global $USER;

    if ($USER->IsAuthorized()) {
        $arFields["AUTHOR"] = 'Пользователь авторизован: ' . $USER->GetID() . ' (' . $USER->GetLogin() . ') ' . $USER->GetFullName() . ', данные из формы: ' . $arFields["AUTHOR"];
    } else {
        $arFields["AUTHOR"] = 'Пользователь не авторизован, данные из формы: ' . $arFields["AUTHOR"];
    }
}
