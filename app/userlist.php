<!-- Default PHP header -->
<?php

require_once('private/path_constants.php');

$page_title = 'Userlist';

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/user_functions.php');
require_once(CLASS_PATH . '/User.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

session_start();

is_logged_in();
session_expired();
only_for_admins();

include(SHARED_PATH . '/header.php');


// Code om gebruiker te verwijderen
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['action'] == 'delete_user')) {
	$user_id = $_POST['user_id'];
	$username = $_POST['username'];
	delete_user($user_id);
	echo "<script type='text/javascript'>alert('Gebruiker " . $username . " verwijderd.');</script>";
}

?>

<!-- Hier komt de content -->
<div id="content" class="container">

	 <div class="table-header-container">
		<h2 class="tabel-header">Gebruikersoverzicht</h2>
		<a href="usercreate">Nieuwe gebruiker aanmaken</a>
	</div>
	<table>
		<thead>
			<tr>
				<th>Gebruikersnaam</th>
				<th>Voornaam</th>
				<th>Achternaam</th>
				<th>Rol</th>
				<th></th>
				<th></th>
				<!-- <th></th> -->
			</tr>
		</thead>
		<tbody>
			<?php $userlist = get_userlist() ?>
			<?php foreach ($userlist as $user) : ?>
			<tr>
				<td><?=$user->username; ?></td>
				<td><?=$user->given_name; ?></td>
				<td><?=$user->family_name; ?></td>
				<td><?=$user->role; ?></td>
				<td>
					<a href="useredit.php?id=<?= $user->get_user_id() ?>" class="icon-link edit-icon"></a>
				</td>
				<td>
					<form id="userdelete-<?= $user->username; ?>" action="userlist" method="post">
						<input type="hidden" name="action" value="delete_user" />
						<input type="hidden" name="user_id" value="<?=$user->user_id; ?>" />
						<input type="hidden" name="username" value="<?=$user->username; ?>" />
						<a class="icon-link delete-icon" onclick="show_modal('<?= $user->username; ?>', 'userdelete-<?= $user->username; ?>')"></a>
					</form>
				</td>
			</tr>
			<?php endforeach; ?>
		
		</tbody>
	</table>
</div>

<div class="modal" id="modal">
	<div id="modal-content">
		<div id="modal-title"><h1>Gebruiker verwijderen</h1></div>
		<div id="modal-p"><p>Weet u zeker dat u <span id="modal-username"></span> wilt verwijderen?</p></div>
		<div id="button-container">
			<button id="modal-delete-button" class="verwijderen" form="" type="submit">Gebruiker verwijderen</button>
			<button onClick="hide_modal()" class="annuleren">Annuleren</button>
		</div>
	</div>
</div>

<!-- Default PHP footer -->
<script type="text/javascript" src="private/js/modal.js"></script>
<?php include(SHARED_PATH . '/footer.php')?>