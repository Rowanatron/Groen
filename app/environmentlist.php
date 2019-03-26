<?php

require_once('private/path_constants.php');

$page_title = 'Environmentlist';

require_once(PRIVATE_PATH . '/environment_functions.php');	
require_once(CLASS_PATH . '/Environment.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');
require_once(CLASS_PATH . '/Customer.php');
require_once(PRIVATE_PATH . '/customer_functions.php');

session_start();

is_logged_in();
session_expired();
only_for_admins();

include(SHARED_PATH . '/header.php');

// Code om omgeving te verwijderen
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['action'] == 'delete_environment')) {
	$environment_id = $_POST['environment_id'];
	$environment_name = $_POST['environment_name'];
	delete_environment($environment_id);
	echo "<script type='text/javascript'>alert('Omgeving " . $environment_name . " verwijderd.');</script>";
}

?>

<!-- Hier komt de content -->
<div id="content" class="container">

	 <div class="table-header-container">
		<h2 class="tabel-header">Omgevingsoverzicht</h2>
		<a href="environmentcreate.php">Nieuwe omgeving aanmaken</a>
	</div>
	<table>
		<thead>
			<tr>
				<th>Omgevingsnaam</th>
				<th>Gekoppelde klant</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
        <tbody>
		<?php $environmentlist = get_environmentlist() ?>
			<?php foreach ($environmentlist as $environment) : ?>
			<tr>
				<td><?=$environment->get_environment_name(); ?></td>
				<td><?=(get_customer_by_id($environment->get_customer_id()))->get_customer_name(); ?></td>
				<td>
					<a href="environmentedit.php?id=<?= $environment->get_environment_id() ?>">
						<i class="material-icons table-icons">mode_edit</i>
					</a>
				</td>
				<td>
					<form id="delete-<?= $environment->get_environment_name(); ?>" action="environmentlist.php" method="post">
						<input type="hidden" name="action" value="delete_environment" />
						<input type="hidden" name="environment_id" value="<?=$environment->get_environment_id(); ?>" />
						<input type="hidden" name="environment_name" value="<?=$environment->get_environment_name(); ?>" />
					</form>
					<a onclick="show_modal('<?= $environment->get_environment_name(); ?>', 'delete-<?= $environment->get_environment_name(); ?>')">
						<i class="material-icons table-icons">delete</i>
					</a>
				</td>
			</tr>
			<?php endforeach; ?>
		
		</tbody>
	</table>
</div>

<div class="modal" id="modal">
	<div id="modal-content">

		<div id="modal-title"><h1>Omgeving verwijderen</h1></div>
		<div id="modal-p"><p>Weet u zeker dat u <span id="modal-name"></span> wilt verwijderen?</p></div>
		<div id="button-container">
			<button id="modal-delete-button" class="verwijderen" form="" type="submit">Omgeving verwijderen</button>
			<button onClick="hide_modal()" class="annuleren">Annuleren</button>
		</div>
	</div>
</div>



<!-- Default PHP footer -->
<script type="text/javascript" src="private/js/modal.js"></script>
<?php include(SHARED_PATH . '/footer.php')?>