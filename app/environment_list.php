<?php

require_once('private/path_constants.php');

$page_title = 'Environmentlist';

require_once(PRIVATE_PATH . '/environment_functions.php');	
require_once(CLASS_PATH . '/Environment.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

session_start();

is_logged_in();
session_expired();
only_for_admins();

include(SHARED_PATH . '/header.php');

// // Code om omgeving te verwijderen
// if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['action'] == 'delete_environment')) {
// 	$environment_id = $_POST['environment_id'];
// 	$environment_name = $_POST['environment_name'];
// 	delete_environment($environment_id);
// 	echo "<script type='text/javascript'>alert('Omgeving " . $environmentname . " verwijderd.');</script>";
// }

?>

<!-- Hier komt de content -->
<div id="content" class="container">

	 <div class="table-header-container">
		<h2 class="tabel-header">Omgevingsoverzicht</h2>
		<a href="environment_create.php">Nieuwe omgeving aanmaken</a>
	</div>
	<table>
		<thead>
			<tr>
				<th>Omgevingsnaam</th>
				<th>Gekoppelde klant</th>
				<th></th>
				<th></th>
				<!-- <th></th> -->
			</tr>
		</thead>
        <tbody>
		<?php $environmentlist = get_environmentlist() ?>
			<?php foreach ($environmentlist as $environment) : ?>
			<tr>
				<td><?=$environment->environment_name; ?></td>
				<td><?=$get_customer_by_id(($environment->customer_id))->customer_name; ?></td>
				<td>
					<form action="environmentedit" method="post">
						<input type="hidden" name="environment_id" value="<?=$environment->environment_id; ?>"/>
						<input type="image" name="submit" src="/img/edit_pencil.png" onmouseover="this.src='/img/edit-hover.png';" onmouseout="this.src='/img/edit_pencil.png';" border="0" alt="bewerk" style="width: 10%; height: 10%;" />
					</form>
				</td>
				<td>
					<form id="environmentdelete-<?= $environment->environment_name; ?>" action="environmentlist" method="post">
						<input type="hidden" name="action" value="delete_environment" />
						<input type="hidden" name="environment_id" value="<?=$environment->environment_id; ?>" />
						<input type="hidden" name="environment_name" value="<?=$environment->environment_name; ?>" />
						<img src="/img/delete.png" onmouseover="this.src='/img/delete-hover.png';" onmouseout="this.src='/img/delete.png';"border="0" alt="delete" style="width: 7%; height: 7%;" onclick="showModal('<?= $environment->environmentname; ?>', 'environmentdelete-<?= $environment->environmentname; ?>')" />
					</form>
				</td>
			</tr>
			<?php endforeach; ?>
		
		</tbody>
	</table>
</div>

<!-- <div class="modal" id="modal">
	<div id="modal-content">

		<div id="modal-title"><h1>Omgeving verwijderen</h1></div>
		<div id="modal-p"><p>Weet u zeker dat u <span id="modal-username"></span> wil verwijderen</p></div>
		<div id="button-container">
			<button id="modal-delete-button" class="verwijderen" form="form-delete" type="submit">Omgeving verwijderen</button>
			<button onClick="hideModal()" class="annuleren">Annuleren</button>
		</div>
	</div>
</div> --> -->



<!-- Default PHP footer -->
<script type="text/javascript" src="../private/modal.js"></script>
<?php include(SHARED_PATH . '/footer.php')?>