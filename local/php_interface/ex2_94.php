<?

AddEventHandler('main', 'OnBeforeProlog', array("Ex2_94", "OnBeforePrologHandler"));

class Ex2_94
{
    public static function OnBeforePrologHandler()
    {
        global $APPLICATION;    
        $curPageDir = $APPLICATION->GetCurDir();

        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $rsMetaTags = CIBlockElement::GetList(array(), array("IBLOCK_TYPE" => "products", "IBLOCK_ID" => METATAGS_IBLOCK, "ACTIVE" => "Y", "NAME" => $curPageDir), false, false, array("PROPERTY_TITLE", "PROPERTY_DESCRIPTION"));
            if ($arMetaTags = $rsMetaTags->Fetch()) {
                $APPLICATION->SetPageProperty("title", $arMetaTags["PROPERTY_TITLE_VALUE"]);
                $APPLICATION->SetPageProperty("description", $arMetaTags["PROPERTY_DESCRIPTION_VALUE"]);
            }
        }
    } 
}
