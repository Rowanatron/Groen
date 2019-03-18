<h2>Gebruikersoverzicht</h2>
<!-- temp styling -->
<style>
	table, tr, th, td {
		border-collapse: collapse;
		border-width: 1px;
		border-style: solid;
	}
	
	td, th {
		padding: 0.5rem;
	}
</style>
<!-- end temp styling -->
<table>
	<tr>
		<th>Gebruikersnaam</th>
		<th>Voornaam</th>
		<th>Achternaam</th>
		<th>Rol</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	<?php 
	
	class User
	{
		public $username;
		public $givenname;
		public $familyname;
		public $isAdmin;
	}
	
	$user1 = new User();
	$user1->username = 'annejan';
	$user1->givenname = 'Anne Jan';
	$user1->familyname = 'Sikkema';
	$user1->isAdmin = 'admin';
	
	$user2 = new User();
	$user2->username = 'charlottevanbrakel';
	$user2->givenname = 'Charlotte';
	$user2->familyname = 'Brakel, van';
	$user2->isAdmin = 'user';
	
	$userArray = array($user1, $user2);
	
	?>
	<!-- For loop -->
	<?php foreach ($userArray as $user) { ?>
	<tr>
		<td><?php echo $user->username ?></td>
		<td><?php echo $user->givenname ?></td>
		<td><?php echo $user->familyname ?></td>
		<td><?php echo $user->isAdmin ?></td>
		<td><a href="#edit-<?php echo $user->username ?>">Edit</a></td>
		<td><a href="#delete-<?php echo $user->username ?>">Delete</a></td>
	</tr>
	<?php } ?>
	<!-- End for loop -->
</table>