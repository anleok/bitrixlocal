<?
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

if (isset($_GET['noinit']) && !empty($_GET['noinit'])) {
    $strNoInit = strval($_GET['noinit']);
    if ($strNoInit == 'N') {
        if (isset($_SESSION['NO_INIT']))
            unset($_SESSION['NO_INIT']);
    } elseif ($strNoInit == 'Y') {
        $_SESSION['NO_INIT'] = 'Y';
    }
}

if (!(isset($_SESSION['NO_INIT']) && $_SESSION['NO_INIT'] == 'Y')) {
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/constants.php"))
        require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/constants.php");
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/ex2_51.php"))
        require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/ex2_51.php");
    if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/ex2_94.php"))
        require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/ex2_94.php");
}
