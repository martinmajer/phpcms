<?php
include "../../../../admin/admin.php";

$id = param_get("id");
$pageFactory = new PageFactory();
$page = $pageFactory->loadSingle($id);

if ($page) {
    if ($page->delete()) {
        form_setSuccessMessage("Stránka byla odstraněna.");
    }
    else form_addError (dbError());
}

redirect(MODULE_CORE_DIR . "/page/list.php");
