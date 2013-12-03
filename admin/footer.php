<?php global $showMenu, $user; ?>

    <?php if (!empty($showMenu)):?>
    <div class="footer">
        <div class="pull-left">
            Administrační rozhraní 
            <a href="<?php echo makeLink("/")?>" target="_blank"><?php echo WEBSITE_NAME;?></a>
        </div>
        <div class="pull-right">
            Přihlášen jako <?php echo $user->username;?>. <a href="<?php echo ADMIN_BASEDIR;?>/?logout=true">Odhlásit se</a>.
        </div>
    </div>
    <?php endif;?>
</div>
</body>
</html>
