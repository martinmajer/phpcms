<?php include "../../../../admin/admin.php";?>
<?php adminHeader(); ?>

<h1>Seznam stránek <a href="<?php echo MODULE_CORE_DIR;?>/page/new.php" class="btn btn-success"><i class="icon-plus icon-white"></i> Nová stránka</a></h1>

<?php form_showMessages(); ?>

<?php
$pageFactory = new PageFactory();
$pages = $pageFactory->loadCollection();

renderTable($pages, array(
    createTableColumn("Jméno stránky", "title", function($page, $input) {
        return "<a href=\"" . MODULE_CORE_DIR . "/page/edit.php?id=" . $page->id . "\">" . $page->title . "</a>";
    }),
    createTableColumn("Text", "text", function($page, $input) {
       return "<small>" . mb_substr(strip_tags($input), 0, 75, "utf-8") . "...</small>";
    }),
    createTableColumn("Adresa", "slug"),
    createTableColumn("", null, function($page, $input) {
        return  createTableAction("icon-zoom-in", "Zobrazit", makeLink($page->slug)) .
                createTableAction("icon-pencil", "Upravit", MODULE_CORE_DIR . "/page/edit.php?id=" . $page->id) . 
                createTableAction("icon-trash", "Smazat", MODULE_CORE_DIR . "/page/delete.php?id=" . $page->id, "", "Opravdu chcete smazat tuto stránku?");
    }, array('align' => 'right', 'nowrap' => true))
));
?>

<?php adminFooter(); ?>
