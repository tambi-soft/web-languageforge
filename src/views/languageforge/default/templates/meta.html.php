        <meta charset="utf-8" />
        <title><?php echo $controller->website->name; ?></title>

        <!-- <link rel="stylesheet" href="/vendor_bower/bootstrap/dist/css/bootstrap.css" /> -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/shared/animate.css" />
        <?php if (isset($cssFiles)): ?>
        <?php foreach($cssFiles as $filename): ?>
        <link rel=stylesheet href="/<?php echo $filename; ?>" />
        <?php endforeach; ?>
        <?php endif; ?>
        <link rel="stylesheet" media="screen" href="/css/languageforge/default/superfish.css" />
        <link rel="stylesheet" media="screen" href="/css/languageforge/default/slides.css" />
        <link rel="stylesheet" media="screen" href="/css/shared/jquery.fileupload-ui.css" />
        <!--
        <link rel="stylesheet" href="/css/languageforge/default/lf-dictionary.css" />
 -->
        <link rel="stylesheet" href="/css/languageforge/default/lf.css" />
        <link rel="stylesheet" href="/css/languageforge/default/lexiquepro.css" />
        <link rel="icon" href="/images/languageforge/default/favicon.ico" type="image/x-icon" />
        <link data-require="font-awesome@*" data-semver="4.2.0" rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.css" />
        <link href="/css/shared/font-awesome.css" rel="stylesheet">
        <!--
        <link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700" rel="stylesheet" type="text/css">
 -->
        <!-- <script src="/vendor_bower/jquery/jquery.min.js"></script> -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <!-- jquery must be the first js to be loaded -->
        <!-- <script src="/vendor_bower/jquery-migrate/jquery-migrate.min.js"></script> -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-migrate/1.2.1/jquery-migrate.min.js"></script>
        <!-- see https://github.com/jquery/jquery-migrate/ -->
        <!-- swap in the script below to show what needs migrating in the browser console
        <script src="//code.jquery.com/jquery-migrate.js"></script>
         -->
