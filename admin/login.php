<?php include "./header.php";?>
<div class="login-wrapper">
    <form class="form-login" action="./" method="post">
        <h2>Administrace</h2>

        <?php if (!empty($loginFailed)):?>
        <div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            Špatné uživatelské jméno nebo heslo!
        </div>
        <?php endif;?>
        
        <input type="text" name="username" class="input-block-level" placeholder="Uživatelské jméno">
        <input type="password" name="password" class="input-block-level" placeholder="Heslo">
        <button class="btn btn-primary" type="submit" name="login" value="true">Přihlásit se</button>
    </form>
</div>
<?php include "./footer.php";?>
