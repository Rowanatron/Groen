
<?php
require_once('../private/pathConstants.php');
require_once('../private/functions.php');

$page_title = 'Userlist';
$page = "userlist";
include(SHARED_PATH . '/header.php');
include(PRIVATE_PATH . '/User.php');
?>

<div id="content" class="container">
 <!-- Hier komt de content -->

	
	 <div class="table-header-container">
		 <h2 class="tabel-header">Gebruikersoverzicht</h2>
		 <a href="usercreate.html">Nieuwe gebruiker aanmaken</a>
	</div>
	<table>
		<tr>
			<th>Gebruikersnaam</th>
			<th>Voornaam</th>
			<th>Achternaam</th>
			<th>Rol</th>
			<th></th>
		</tr>

		<?php
			include '../private/DatabasePDO.php';
			$pdo = new DatabasePDO();
			$conn = $pdo->get();
			$query = "SELECT * FROM userlist ORDER BY username;";
			
			try {
				$statement = $conn->prepare($query);
				$statement->execute();
			} catch (PDOException $e) {
				echo "Connection failed: {$e->getMessage()}";
			}
			
			$userArray = array();
			
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				$user = new User($row['username'], $row['password'], $row['givenname'], $row['familyname'], $row['email'], $row['role']);
				array_push($userArray, $user);
			}	
		?>
		
		<!-- For loop -->
		<?php foreach ($userArray as $user) { ?>
		<tr>
			<td><?php echo $user->username ?></td>
			<td><?php echo $user->givenname ?></td>
			<td><?php echo $user->familyname ?></td>
			<td><?php echo $user->role ?></td>
			<td><a href="#edit-<?php echo $user->username ?>"></a><a href="#delete-<?php echo $user->username ?>"></a></td>
		</tr>
		<?php } ?>
		<!-- End for loop -->
		
	</table>

</div>

<?php include(SHARED_PATH . '/footer.php')?>