<?php include "../../../admin/admin.php";?>
<?php adminHeader(); ?>

<?php

global $user; /* @var $user User */

if (form_isSubmittedBy("change")) {
    $oldPassword = param_post("oldPassword");
    $newPassword = param_post("newPassword");
    $newPasswordCheck = param_post("newPasswordCheck");
    
    if (md5($oldPassword) != $user->passwordMd5) {
        form_addError("Špatné heslo!");
    }
    else {
        if (!$newPassword || strlen($newPassword) < 5) {
            form_addError("Nové heslo musí být dlouhé minimálně 5 znaků.");
        }
        if ($newPasswordCheck != $newPassword) {
            form_addError("Nová hesla se neshodují - neudělali jste při psaní překlep?");
        }
    }
    
    if (form_isOk()) {
        $user->passwordMd5 = md5($newPassword);
        $user->updatePassword();
        
        form_setSuccessMessage("Heslo bylo úspěšně změněno.");
    }
    
}

?>

<h1>Změna hesla uživatele</h1>

<form method="post" class="form-edit">
    <?php form_showMessages(); ?>
    
    <label>Původní heslo:</label>
    <input type="password" name="oldPassword" class="span4" />
    
    <label>Nové heslo:</label>
    <input type="password" name="newPassword" class="span4" />
    
    <label>Nové heslo (podruhé):</label>
    <input type="password" name="newPasswordCheck" class="span4" />
    
    <div class="form-inline">
        <button type="submit" name="change" class="btn btn-primary">Změnit heslo</button>
    </div>
</form>

<?php adminFooter(); ?>