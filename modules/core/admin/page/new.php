<?php
include "../../../../admin/admin.php";

$title = "";
$template = "page";
$slug = "";
$meta = "";
$text = "";

if (form_isSubmittedBy("create")) {
    $title = param_post("title");
    $template = param_post("template");
    $slug = param_post("slug");
    $meta = param_post("meta");
    $text = param_post("text");
    
    if ($title == "") {
        form_addError("Titulek stránky nesmí být prázdný.");
    }
    
    if ($slug == "") {
        form_addError("Vyplňte prosím adresu (slug) stránky.");
    }
    
    if (form_isOk()) {
        $page = new Page();
        $page->title = $title;
        $page->template = $template;
        $page->slug = $slug;
        $page->meta = $meta;
        $page->text = $text;
        
        if ($page->save()) {
            form_setSuccessMessage("Nová stránka byla úspěšně vytvořena.");
            redirect(MODULE_CORE_DIR . "/page/list.php");
        }
        else form_addError(dbError());
    }
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

<h1>Nová stránka</h1>

<form action="<?php echo MODULE_CORE_DIR?>/page/new.php" method="post" class="form-edit">
    <?php form_showMessages(); ?>
    
    <input type="text" name="title" value="<?php echo fix($title);?>" placeholder="Jméno stránky" class="span12 input-title" />
    
    <div class="row">
        <div class="span2">
            <label>Šablona:</label>
            <select name="template" class="span2">
            <?php
            $tplLoader = new TemplateLoader();
            foreach ($tplLoader->listTemplateFiles() as $tpl) {
                $selected = ($tpl == $template) ? " selected" : "";
                echo "<option{$selected}>$tpl</option>";
            }
            ?>
            </select>
        </div>
        
        <div class="span2">
            <label>Adresa:</label>
            <input type="text" name="slug" value="<?php echo fix($slug);?>" class="span2">
        </div>
        
        <div class="span8">
            <label>Meta (SEO) popis:</label>
            <input type="text" name="meta" value="<?php echo fix($meta);?>" class="span8">
        </div>
    </div>
    
    <label>Text:</label>
    <textarea name="text" rows="15" class="span12 tinymce-textarea"><?php echo fix($text);?></textarea>
    
    
    <div class="form-inline">
        <button type="submit" name="create" class="btn btn-primary">Vytvořit novou stránku</button>
        <a href="<?php echo MODULE_CORE_DIR?>/page/list.php" class="btn">Zpět</a>
    </div>
</form>

<?php adminFooter(); ?>
