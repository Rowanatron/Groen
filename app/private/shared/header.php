<?php
    if(!isset($page_title)) { $page_title = 'Groen'; }
	$pagename = basename($_SERVER['PHP_SELF']);
?>

<!doctype html>

<html lang="en">
  <head>
    <title><?=$page_title; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/css/css-reset.css'); ?>">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/css/styles.css'); ?>">
	<?php if ($pagename == "createuser.php" || $pagename == "useredit.php" ): ?>
	<link rel="stylesheet" media="all" href="<?php echo url_for('/css/form.css'); ?>">
	<?php endif; ?>
	<?php if ($pagename == "systemoverview.php" || $pagename == "systemoverview2.php" ): ?>
	<link rel="stylesheet" media="all" href="<?php echo url_for('/css/sys-overview.css'); ?>">
	<?php endif; ?>
  </head>

  <body>
  	<header>
	  	<div class="container">
          <a class="logo" href="systemoverview.php"> <img class="logo" src="<?= url_for('/img/logo.jpg'); ?>" alt="Logo"> </a>
          
		  <ul>
		  
			<li <?php if($pagename == "systemoverview.php") : ?>class="active"<?php endif; ?>>
				<a href="systemoverview.php">Monitor</a>
			</li>
			
			<li <?php if($pagename == "userlist.php" || $pagename == "createuser.php" || $pagename == "useredit.php") : ?>class="active"<?php endif; ?>>
			<?php 
			$user = $_SESSION["user"];
			if ($user->get_role() === "admin") {
		  ?>
				<a href="userlist.php">Gebruikers</a>
			</li>
			<?php } ?>
          </ul>
          <a class="uitloggen-link-header" href="../private/logout.php">Uitloggen</a>
        </div>
  	</header>
	
	