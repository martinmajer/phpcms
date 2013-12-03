<?php

define("MODULE_CORE_DIR", WWW_BASEDIR . "/modules/core/admin");
define("UPLOAD_DIR", dirname(__FILE__) . "/../../upload");

registerMenuItem("Stránky", MODULE_CORE_DIR . "/page/list.php", 100);

registerMenuItem("Nástroje", "#module-core-tools", 200, array(
    // createMenuItem("Editor menu", "", 100),
    createMenuItem("Nahrávání souborů", MODULE_CORE_DIR . "/upload/list.php", 200)
));

registerMenuItem("Nastavení", "", 300, array(
    createMenuItem("Změna hesla", MODULE_CORE_DIR . "/password-change.php", 100)
));
