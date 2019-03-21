<!-- Default PHP header -->
<?php

require_once('../private/pathConstants.php');

$page_title = 'Userlist';
$page = "userlist";

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/userfunctions.php');
require_once(PRIVATE_PATH . '/User.php');

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
		<a href="createuser.php">Nieuwe gebruiker aanmaken</a>
	</div>
	<table>
		<thead>
			<tr>
				<th>Gebruikersnaam</th>
				<th>Voornaam</th>
				<th>Achternaam</th>
				<th>Rol</th>
				<th>Bewerk</th>
				<th>Verwijder</th>
				<!-- <th></th> -->
			</tr>
		</thead>
		<tbody>
			<?php foreach (get_userlist() as $user) : ?>
			<tr>
				<td><?=$user->username; ?></td>
				<td><?=$user->given_name; ?></td>
				<td><?=$user->family_name; ?></td>
				<td><?=$user->role; ?></td>
				<td>
					<form action="useredit.php" method="post">
						<input type="hidden" name="user_id" value="<?=$user->user_id; ?>"/>
						<input type="image" name="submit" src="../public/img/edit_pencil.png" border="0" alt="bewerk" style="width: 10%; height: 10%;" />
					</form>
				</td>
				<td>
					<form action="userlist.php" method="post" onsubmit="return confirm('Weet u zeker dat u <?=$user->username; ?> wilt verwijderen?');">
						<input type="hidden" name="action" value="delete_user" />
						<input type="hidden" name="user_id" value="<?=$user->user_id; ?>" />
						<input type="hidden" name="username" value="<?=$user->username; ?>" />
						<input type="image" src="../public/img/delete_bin.png" border="0" alt="delete" style="width: 10%; height: 10%;" />
					</form>
				</td>
				<!-- <td><a href="#edit-<? // =$user->username; ?>"></a><a href="#delete-<? // =$user->username; ?>"></a></td> -->
			</tr>
			<?php endforeach; ?>
		
		</tbody>
	</table>
</div>

<!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>