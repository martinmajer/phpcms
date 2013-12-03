<?php 
include "../../../../admin/admin.php";

if (form_isSubmittedBy("upload")) {
    $ok = true;
    if ($_FILES['file']['error'] > 0) {
        $ok = false;
    }
    else {
        $name = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        
        if (move_uploaded_file($temp, UPLOAD_DIR . "/" . $name)) $ok = true;
        else $ok = false;
    }
    
    if ($ok) {
        form_setSuccessMessage("Soubor byl úspěšně nahraný.");
    }
    else {
        form_addError("Soubor se nepodařilo nahrát.");
    }
}

if ($delete = param_get("delete")) {
    $delete = base64_decode($delete);
    
    if (unlink(UPLOAD_DIR . "/" . basename($delete))) {
        form_setSuccessMessage("Soubor byl odstraněn.");
    }
    else {
        form_addError("Soubor se nepodařilo odstranit.");
    }
}
?>
<?php adminHeader(); ?>

<h1>Nahrávání obrázků a souborů <a href="#" onclick="$('#uploadForm').slideDown(); return false;" class="btn btn-success"><i class="icon-plus icon-white"></i> Nahrát soubor</a></h1>

<?php form_showMessages(); ?>

<form method="post" enctype="multipart/form-data" action="<?php echo MODULE_CORE_DIR;?>/upload/list.php" style="display: none;" id="uploadForm" class="form-inline">
    <input type="file" name="file" title="Vyberte soubor z počítače" />
    <button type="submit" name="upload" class="btn btn-primary">Nahrát soubor</button>
    <small>Maximální velikost souboru: <?php echo (int)ini_get('upload_max_filesize'); ?> MB</small>
</form>
<script>
    $(function() {
        $('input[type=file]').bootstrapFileInput();
    });
</script>

<?php

$files = glob(UPLOAD_DIR . "/*");

if ($files) {
    usort($files, function($a, $b) { return filemtime($b) - filemtime($a); });
    $paginator = new Paginator();
    $paginator->setCount(count($files));

    renderTable($files, array(
        createTableColumn("Jméno soboru", null, function($file, $input) { return "<a href=\"" . makeLink("upload/" . basename($file)) . "\">" . basename($file) . "</a>";}),
        createTableColumn("Vloženo", null, function($file, $input) { return formatTime(filemtime($file)); }),
        createTableColumn("", null, function($file, $input) {
           return   createTableAction("icon-zoom-in", "Zobrazit", makeLink("upload/" . basename($file))) .
                    createTableAction("icon-trash", "Smazat", MODULE_CORE_DIR . "/upload/list.php?delete=" . base64_encode(basename($file)), "", "Opravdu chcete smazat tento soubor?");
        }, array('align' => 'right', 'nowrap' => true))
        ), array('paginator' => $paginator, 'showId' => false)
    );
}
else {
    echo "<p>Zatím jste nenahráli žádné soubory.</p>";
}
?>

<?php adminFooter(); ?>
