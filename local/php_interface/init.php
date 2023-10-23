<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

AddEventHandler('main', 'OnBeforeEventSend', "OnBeforeEventSendHandler");

/*
Вызывается перед отправкой сообщения
*/
function OnBeforeEventSendHandler($arFields, $arTemplate)
{
    global $USER;

    if ($USER->IsAuthorized()) {
        /* если пользователь авторизован  */
        $arFields["AUTHOR"] = 'Пользователь авторизован: ' . $USER->GetID() . ' (' . $USER->GetLogin() . ') ' . $USER->GetFullName() . ', данные из формы: ' . $arFields["AUTHOR"];
    } else {
        /* если пользователь не авторизован  */
        $arFields["AUTHOR"] = 'Пользователь не авторизован, данные из формы: ' . $arFields["AUTHOR"];
    }
}
