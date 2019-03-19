<?php
    if(!isset($page_title)) { $page_title = 'Groen'; }
?>


<!doctype html>

<html lang="en">
  <head>
    <title><?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/css/styles.css'); ?>">
  </head>

  <body>
  	<header>
	  	<div class="container">
          <img class="logo" src="<?php echo url_for('/img/logo.jpg'); ?>" alt="Logo">
        </div>
  	</header>
