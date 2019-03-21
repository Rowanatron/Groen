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
	<?php if ($pagename == "createuser.php"): ?>
	<link rel="stylesheet" media="all" href="<?php echo url_for('/css/form.css'); ?>">
	<?php endif; ?>
  </head>

  <body>
  	<header>
	  	<div class="container">
          <img class="logo" src="<?= url_for('/img/logo.jpg'); ?>" alt="Logo">
          
		  <ul>
		  
			<li <?php if($pagename == "systemoverview.php") : ?>class="active"<?php endif; ?>>
				<a href="systemoverview.php">Monitor</a>
			</li>
			
			<?php if(isset($_SESSION["isAdmin"])) : ?>
			<li <?php if($pagename == "userlist.php") : ?>class="active"<?php endif; ?>>
				<a href="userlist.php">Gebruikers</a>
			</li>
			<?php endif; ?>
          </ul>
          <a class="uitloggen-link-header" href="../private/logout.php">Uitloggen</a>
        </div>
  	</header>
	
		<!-- <form action="../private/logout.php">
			<button type="submit" onclick="alert('U bent succesvol uitgelogd')">Log uit</button>  
        </form> -->