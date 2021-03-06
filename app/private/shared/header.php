<?php 

require_once(CLASS_PATH . '/User.php');
require_once(PRIVATE_PATH . '/user_functions.php');
$pagename = basename($_SERVER['PHP_SELF']); 
$user_from_session = $_SESSION["user"];
$user = get_user_by_id($user_from_session->get_user_id()); 

?>
<!doctype html>

<html lang="en">

<head>
    <title>Server Monitor<?= isset($page_title) ? ' - ' . $page_title : ''; ?>		
	</title>
    <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
    <meta charset="utf-8">
	<!-- General styling -->
    <link rel="stylesheet" media="all" href="css/css-reset.css">
    <link rel="stylesheet" media="all" href="css/styles.css">
    <!-- Form styling -->
	<?php if (
		$pagename == "usercreate.php" ||
		$pagename == "useredit.php" ||
		$pagename == "customercreate.php" ||
		$pagename == "customeredit.php" ||
		$pagename=="environmentcreate.php" ||
		$pagename =="env_vm_relation_create.php" ||
		$pagename == "user.php" ||
		$pagename == "environmentedit.php" ||
    $pagename == "systemoverview.php" ||
		$pagename == "relationcreate.php") : ?>
	  <link rel="stylesheet" media="all" href="css/form.css">
	<?php endif; ?>
	<!-- System overview styling & JavaScript-->
	<?php if ($pagename == "user.php"): ?>
	<link rel="stylesheet" media="all" href="css/default_modal.css">
	<?php endif; ?>
	<?php if ($pagename == "systemoverview.php"): ?>
	<link rel="stylesheet" media="all" href="css/sys-overview.css">
    <link rel="stylesheet" media="all" href="css/sys-overview-modal.css">
    <link rel="stylesheet" media="all" href="css/progressbar.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<?php endif; ?>
	<!-- Table styling & Google Icons -->
	<?php if ($pagename == "userlist.php" ||  $pagename == "customerlist.php" || $pagename == "environmentlist.php") : ?>
    <link rel="stylesheet" media="all" href="css/table.css">
	<?php endif; ?>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>

  <body>
  	<header>
	  	<div class="container">
			<a class="logo" href="systemoverview">
				<img class="logo" src="img/logo.jpg" alt="Logo">
			</a>
          
			<ul>
		  
				<li <?= ($pagename == "systemoverview.php") ? "class='active'" : ""?>>
					<a href="systemoverview">Monitor</a>
				</li>
				
				<?php if ($_SESSION["user"]->get_role() === "admin") : ?>
					<li <?= ($pagename == "userlist.php" || $pagename == "user.php") ? "class='active'" : ""?>">
						<a href="userlist">Gebruikers</a>
					</li>
					<li <?= ($pagename == "customerlist.php" || $pagename == "customercreate.php" || $pagename == "customeredit.php") ? "class='active'" : "" ?>">
						<a href="customerlist">Klanten</a>
					</li>
					<li <?= ($pagename == "environmentlist.php") ? "class='active'" : "" ?>>
						<a href="environmentlist">Omgevingen</a>
					</li>
				<?php endif; ?>
			
			</ul>
			
			<div class="dropdown">
				<div>
					<a href="useredit">
						<img class="user_img" src="img/uploads/<?= ($user->get_img() != null) ? $user->get_img() : "placeholder.png" ?>" />
					</a>
					<i class="material-icons size-icons">keyboard_arrow_down</i>
			
					<div class="dropdown-container">
						<nav class="dropdown-content">
							<ul class="dropdown-list">
								<li>
									<a href="user-edit">Profiel</a>
								</li>
								<li>
									<a href="logout">Uitloggen</a>
								</li>
							</ul>
						</nav>
					</div>
					
				</div>
			</div>
			
        </div>
    </header> 