<!-- Default PHP header -->
<?php

require_once('../private/pathConstants.php');

$page_title = 'Userlist';
$page = "userlist";

require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/userfunctions.php');
require_once(PRIVATE_PATH . '/User.php');

include(SHARED_PATH . '/header.php');

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
				<input type="submit" value="Bewerk">
				</td>
				<!-- <td><a href="#edit-<? // =$user->username; ?>"></a><a href="#delete-<? // =$user->username; ?>"></a></td> -->
			</tr>
			<?php endforeach; ?>
		
		</tbody>
	</table>
	<?php 
		$userK3 = get_user_by_username('Kareltje3!'); 
		echo $userK3->username;
	?>
	
	<?=$userK3->username; ?>
	<?=$userK3->given_name; ?>
	<?=$userK3->family_name; ?>
	<?=$userK3->role; ?>
	<?=$userK3->password; ?>
</div>

<!-- Default PHP footer -->
<?php include(SHARED_PATH . '/footer.php')?>