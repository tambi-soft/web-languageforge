		<meta charset="utf-8" />
		<!--  <meta name="viewport" content="width=device-width" />-->
		<title><?php echo $controller->website->name; ?></title>
		
		<link rel="stylesheet" href="/css/shared/bootstrap.css" />
        <link rel="stylesheet" href="/css/shared/animate.css" />
		<?php if (isset($cssFiles)): ?>
		<?php foreach($cssFiles as $filename): ?>
		<link rel=stylesheet href="/<?php echo $filename; ?>" />
		<?php endforeach; ?>
		<?php endif; ?>
		<link rel="stylesheet" media="screen" href="/css/scriptureforge/default/superfish.css" />
		<link rel="stylesheet" media="screen" href="/css/scriptureforge/default/slides.css" />
		<link rel="stylesheet" href="/css/shared/font-awesome.css">
		<link rel="stylesheet" href="/css/scriptureforge/default/sf.css" />
		<link rel="stylesheet" href="/css/scriptureforge/default/sf-ui.css" />
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<link href="//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700" rel="stylesheet" type="text/css">

		<script src="/js/lib/jquery-1.8.3.min.js"></script>
		<!--  jquery *must* be the first to js to load -->
