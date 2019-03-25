<?php
if (!isset($page_title)) {
	$page_title = 'Groen';
}
$pagename = basename($_SERVER['PHP_SELF']);
?>

<!doctype html>

<html lang="en">

<head>
    <title><?= $page_title; ?></title>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" media="all" href="css/css-reset.css">
    <link rel="stylesheet" media="all" href="css/styles.css">
	<?php if ($pagename == "usercreate.php" || $pagename == "useredit.php" || $pagename == "customercreate.php" || $pagename == "customeredit.php" || $pagename=="environment_create.php"): ?>
	<link rel="stylesheet" media="all" href="css/form.css">
	<?php endif; ?>
	<?php if ($pagename == "systemoverview.php"): ?>
	<link rel="stylesheet" media="all" href="css/sys-overview.css">
	<?php endif; ?>
  </head>

  <body>
  	<header>
	  	<div class="container">
          <a class="logo" href="systemoverview"> <img class="logo" src="img/logo.jpg" alt="Logo"> </a>
          
		  <ul>
		  
			<li <?php if($pagename == "systemoverview.php") : ?>class="active"<?php endif; ?>>
				<a href="systemoverview">Monitor</a>
			</li>
			
			<li <?php if($pagename == "userlist.php" || $pagename == "usercreate.php" || $pagename == "useredit.php") : ?>class="active"<?php endif; ?>>
			<?php 
			$user = $_SESSION["user"];
			if ($user->get_role() === "admin") {
		  ?>
				<a href="userlist">Gebruikers</a>
			</li>
			<?php } ?>
          </ul>
          <a class="uitloggen-link-header" href="logout">Uitloggen</a>
        </div>
    </header> 