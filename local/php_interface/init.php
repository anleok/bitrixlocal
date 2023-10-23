<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

AddEventHandler('main', 'OnBeforeEventSend', array("userFeedbackForm", "OnBeforeEventSendHandler"));
AddEventHandler('main', 'OnEventLogGetAuditTypes', array("userFeedbackForm", "OnEventLogGetAuditTypes"));

class userFeedbackForm
{
    public static function OnBeforeEventSendHandler(&$arFields, &$arTemplate)
    {
        global $USER;

        if ($USER->IsAuthorized()) {
            /* если пользователь авторизован  */
            $arFields["AUTHOR"] = 'Пользователь авторизован: ' . $USER->GetID() . ' (' . $USER->GetLogin() . ') ' . $USER->GetFullName() . ', данные из формы: ' . $arFields["AUTHOR"];
        } else {
            /* если пользователь не авторизован  */
            $arFields["AUTHOR"] = 'Пользователь не авторизован, данные из формы: ' . $arFields["AUTHOR"];
        }

        // добавляем событие в журнал событий
        CEventLog::Add(array(
            "SEVERITY" => "INFO",
            "AUDIT_TYPE_ID" => "FEEDBACKFORM_AUTHOR_REWRITE_TYPE",
            "MODULE_ID" => "main",
            "ITEM_ID" => 123,
            "DESCRIPTION" => "Замена данных в отсылаемом письме – " . $arFields["AUTHOR"],
         ));
    }

    public static function OnEventLogGetAuditTypes()
    {
       return array('FEEDBACKFORM_AUTHOR_REWRITE_TYPE' => '[FEEDBACKFORM_AUTHOR_REWRITE_TYPE] Замена данных в отсылаемом письме');
    }
}
