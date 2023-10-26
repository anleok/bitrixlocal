<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?></b></p>
<?= GetMessage("SIMPLECOMP_EXAM2_TIME") ?> <?echo time();?>
<? if (is_countable($arResult["CLASSIFIER"]) && count($arResult["CLASSIFIER"]) > 0) { ?>
    <ul>
        <? foreach ($arResult["CLASSIFIER"] as $arClassifier) { ?>
            <li>
                <b><?= $arClassifier["NAME"]; ?></b>
                <? if (is_countable($arClassifier["ELEMENTS"]) && count($arClassifier["ELEMENTS"]) > 0) { ?>
                    <ul>
                        <? foreach ($arClassifier["ELEMENTS"] as $arItem) { ?>
                            <li><?= $arItem["NAME"]; ?> - <?= $arItem["PROPERTIES"]["PRICE"]["VALUE"]; ?> - <?= $arItem["PROPERTIES"]["MATERIAL"]["VALUE"]; ?> - <?= $arItem["PROPERTIES"]["ARTNUMBER"]["VALUE"]; ?> - <a href="<?= $arItem["DETAIL_PAGE_URL"]; ?>">подробнее</a></li>
                        <? } ?>
                    </ul>
                <? } ?>
            </li>
        <? } ?>
    </ul>
<? } ?>