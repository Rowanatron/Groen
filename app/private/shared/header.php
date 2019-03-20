<?php
    if(!isset($page_title)) { $page_title = 'Groen'; }
?>

<!doctype html>

<html lang="en">
  <head>
    <title><?=$page_title; ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/css/css-reset.css'); ?>">
    <link rel="stylesheet" media="all" href="<?php echo url_for('/css/styles.css'); ?>">
	<?php if ($page == "createuser"): ?>
	<link rel="stylesheet" media="all" href="<?php echo url_for('/css/form.css'); ?>">
	<?php endif; ?>
  </head>

  <body>
  	<header>
	  	<div class="container">
          <img class="logo" src="<?php echo url_for('/img/logo.jpg'); ?>" alt="Logo">
          <ul>
			<li class="<?php if($page == "systemoverview") {echo "active";} ?>"><a href="systemoverview.php">Monitor</a></li>
			<?php if(isset($_SESSION["isAdmin"])) : ?>
			<li class="<?php if($page == "userlist") {echo "active";} ?>"><a href="userlist.php">Gebruikers</a></li>
			<?php endif; ?>
          </ul>
          <a class="uitloggen-link-header" href="../private/logout.php">Uitloggen</a>
        </div>
  	</header>
		<!-- <form action="../private/logout.php">
			<button type="submit" onclick="alert('U bent succesvol uitgelogd')">Log uit</button>  
        </form> -->