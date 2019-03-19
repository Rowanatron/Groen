
<?php
require_once('../private/initialize.php');

$page_title = 'Userlist';
include(SHARED_PATH . '/header.php');
include(PRIVATE_PATH . '/User.php');
?>

<div id="content">
 <!-- Hier komt de content -->

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
		include '../private/DatabasePDO.php';
		$pdo = new DatabasePDO();
		$connection = $pdo->get();
		$query = "SELECT * FROM users";
		
		try {
			$statement = $connection->prepare($query);
			$statement->execute($data);
		} catch (PDOException $e) {
			echo "Connection failed: {$e->getMessage()}";
		}
		
		while($row = $statement->fetch(PDO::FETCH_ASSOC)){
			echo $row['username'];
			echo $row['password'];
		}

		// Voorbeeld users
		$user1 = new User("annejan", "annejan", "Anne Jan", "Sikkema", "anne@jan.nl", "user");
		$user2 = new User("charlotte", "charlotte", "Charlotte", "Brakel, van", "charlotte@brakelvan.nl", "admin");		
		$userArray = array($user1, $user2);
		
		?>
		
		<!-- For loop -->
		<?php foreach ($userArray as $user) { ?>
		<tr>
			<td><?php echo $user->username ?></td>
			<td><?php echo $user->givenname ?></td>
			<td><?php echo $user->familyname ?></td>
			<td><?php echo $user->admin ?></td>
			<td><a href="#edit-<?php echo $user->username ?>">Edit</a></td>
			<td><a href="#delete-<?php echo $user->username ?>">Delete</a></td>
		</tr>
		<?php } ?>
		<!-- End for loop -->
		
	</table>

</div>

<?php include(SHARED_PATH . '/footer.php')?>