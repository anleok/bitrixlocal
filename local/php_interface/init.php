<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

AddEventHandler('main', 'OnBeforeEventSend', array("Ex2AllType", "OnBeforeEventSendHandler"));
AddEventHandler('main', 'OnEventLogGetAuditTypes', array("Ex2AllType", "OnEventLogGetAuditTypes"));
AddEventHandler('main', 'OnBeforeProlog', array("Ex2AllType", "OnBeforePrologHandler"));

class Ex2AllType
{
    /* 
    ex2-51
    */
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

    /* 
    ex2-94
    */
    public static function OnBeforePrologHandler()
    {
        global $APPLICATION;    
        $curPageDir = $APPLICATION->GetCurDir();

        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $rsMetaTags = CIBlockElement::GetList(array(), array("IBLOCK_TYPE" => "products", "IBLOCK_ID" => 5, "ACTIVE" => "Y", "NAME" => $curPageDir), false, false, array("PROPERTY_TITLE", "PROPERTY_DESCRIPTION"));
            if ($arMetaTags = $rsMetaTags->Fetch()) {
                $APPLICATION->SetPageProperty("title", $arMetaTags["PROPERTY_TITLE_VALUE"]);
                $APPLICATION->SetPageProperty("description", $arMetaTags["PROPERTY_DESCRIPTION_VALUE"]);
            }
        }
    } 
}
