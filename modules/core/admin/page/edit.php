<?php
include "../../../../admin/admin.php";

$id = param_get("id");
$pageFactory = new PageFactory();
$page = $pageFactory->loadSingle($id);

if (!$page) header_404();

if (form_isSubmittedBy("update")) {
    $title = param_post("title");
    $template = param_post("template");
    $slug = param_post("slug");
    $meta = param_post("meta");
    $text = param_post("text");
    
    if ($title != "") {
        $page->title = $title;
    }
    else {
        form_addError("Titulek stránky nesmí být prázdný.");
    }
    
    $page->template = $template;
    
    if ($slug != "") {
        $page->slug = $slug;
    }
    else {
        form_addError("Vyplňte prosím adresu (slug) stránky.");
    }
    
    $page->meta = $meta;
    $page->text = $text;
    
    if ($page->update()) {
        form_setSuccessMessage("Stránka byla upravena.");
    }
    else form_addError(dbError());
}

?>
<?php adminHeader(); ?>

<script type="text/javascript" src="<?php echo ADMIN_BASEDIR;?>/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
        mode: "textareas",
        theme: "advanced",
        skin: "default",
        theme_advanced_buttons1: "bold, italic, strikethrough, sub, sup, bullist, numlist, link, unlink, formatselect, removeformat, image, code, |, cut, copy, paste, undo, redo",
        theme_advanced_blockformats: "p,h2,h3,h4,blockquote",
        entity_encoding: "raw"
});
</script>

<h1>Editace stránky</h1>

<form action="<?php echo MODULE_CORE_DIR?>/page/edit.php?id=<?php echo $id;?>" method="post" class="form-edit">
    <?php form_showMessages(); ?>
    
    <input type="text" name="title" value="<?php echo fix($page->title);?>" placeholder="Jméno stránky" class="span12 input-title" />
    
    <div class="row">
        <div class="span2">
            <label>Šablona:</label>
            <select name="template" class="span2">
            <?php
            $tplLoader = new TemplateLoader();
            foreach ($tplLoader->listTemplateFiles() as $tpl) {
                $selected = ($tpl == $page->template) ? " selected" : "";
                echo "<option{$selected}>$tpl</option>";
            }
            ?>
            </select>
        </div>
        
        <div class="span2">
            <label>Adresa:</label>
            <input type="text" name="slug" value="<?php echo fix($page->slug);?>" class="span2">
        </div>
        
        <div class="span8">
            <label>Meta (SEO) popis:</label>
            <input type="text" name="meta" value="<?php echo fix($page->meta);?>" class="span8">
        </div>
    </div>
    
    <label>Text:</label>
    <textarea name="text" rows="15" class="span12 tinymce-textarea"><?php echo fix($page->text);?></textarea>
    
    
    <div class="form-inline">
        <button type="submit" name="update" class="btn btn-primary">Upravit stránku</button>
        <a href="<?php echo MODULE_CORE_DIR?>/page/list.php" class="btn">Zpět</a>
    </div>
</form>

<?php adminFooter(); ?>
