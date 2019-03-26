<?php $pagename = basename($_SERVER['PHP_SELF']); ?>

<!doctype html>

<html lang="en">

<head>
    <title>Server Monitor<?= isset($page_title) ? ' - ' . $page_title : ''; ?>		
	</title>
    <meta charset="utf-8">
	<!-- General styling -->
    <link rel="stylesheet" media="all" href="css/css-reset.css">
    <link rel="stylesheet" media="all" href="css/styles.css">
    <!-- Form styling -->
	<?php if ($pagename == "usercreate.php" || $pagename == "useredit.php" || $pagename == "customercreate.php"
        || $pagename == "customeredit.php" || $pagename=="environmentcreate.php" || $pagename =="env_vm_relation_create.php" || $pagename == "environmentedit.php"): ?>
	<link rel="stylesheet" media="all" href="css/form.css">
	<?php endif; ?>
	<!-- System overview styling & JavaScript-->
	<?php if ($pagename == "systemoverview.php"): ?>
	<link rel="stylesheet" media="all" href="css/sys-overview.css">
    <link rel="stylesheet" media="all" href="css/progressbar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<?php endif; ?>
	<!-- Table styling & Google Icons -->
	<?php if ($pagename == "userlist.php" ||  $pagename == "customerlist.php" || $pagename == "environmentlist.php") : ?>
    <link rel="stylesheet" media="all" href="css/table.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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

			<?php if ($_SESSION["user"]->get_role() === "admin") { ?>
				<li <?php if($pagename == "userlist.php" || $pagename == "usercreate.php" || $pagename == "useredit.php") : ?>class="active"<?php endif; ?>>
					<a href="userlist">Gebruikers</a>
				</li>
				<li <?php if($pagename == "customerlist.php" || $pagename == "customercreate.php" || $pagename == "customeredit.php") : ?>class="active"<?php endif; ?>>
					<a href="customerlist">Klanten</a>
				</li>
				<li <?php if($pagename == "environmentlist.php") : ?>class="active"<?php endif; ?>>
					<a href="environmentlist">Omgevingen</a>
				</li>
			<?php } ?>
          </ul>
          <a class="uitloggen-link-header" href="logout">Uitloggen</a>
        </div>
    </header> 