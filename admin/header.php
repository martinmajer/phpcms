<?php global $showMenu; ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Administrace</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="<?php echo ADMIN_BASEDIR;?>/css/bootstrap.min.css" rel="stylesheet" media="screen" />
    <link href="<?php echo ADMIN_BASEDIR;?>/css/admin.css" rel="stylesheet" media="screen" />

    <script src="<?php echo ADMIN_BASEDIR;?>/js/jquery-1.10.1.min.js"></script>
    <script src="<?php echo ADMIN_BASEDIR;?>/js/bootstrap.min.js"></script>
    <script src="<?php echo ADMIN_BASEDIR;?>/js/bootstrap.file-input.js"></script>

    <style type="text/css">
        .login-wrapper {
            padding: 5em 0;
        }
        .form-login {
            margin: auto;
            width: 320px;
        }
        
        .footer {
            border-top: 1px solid #ddd;
            font-size: 90%;
            margin-top: 4em;
            padding-top: 1em;
        }
    </style>
</head>
<body>
    <?php if (!empty($showMenu)):?>
    <div class="navbar navbar-inverse navbar-static-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="<?php echo ADMIN_BASEDIR;?>/"><?php echo WEBSITE_NAME;?></a>
                <div class="pull-left">
                    <?php writeMenu(getMenuStruct());?>
                </div><!--/.nav-collapse -->
                <div class="pull-right" style="padding-top: 0.3em;">
                    <a class="btn btn-mini" href="<?php echo ADMIN_BASEDIR;?>/?logout=true"><i class="icon-off"></i> Odhlásit se</a>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="container" style="margin-top: 1em;">