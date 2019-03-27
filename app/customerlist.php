<!-- Default PHP header -->
<?php

require_once('private/path_constants.php');

$page_title = 'Customerlist';

require_once('private/functions.php');
require_once('private/customer_functions.php');
require_once('private/class/Customer.php');
require_once('private/authorisation_functions.php');

session_start();
is_logged_in();
session_expired();
only_for_admins();

include('private/shared/header.php');

// Code om klant te verwijderen
if (($_SERVER['REQUEST_METHOD'] == 'POST') && ($_POST['action'] == 'delete_customer')) {
	$customer_id = $_POST['customer_id'];
	$customer_name = $_POST['customer_name'];
	delete_customer($customer_id);
	echo "<script type='text/javascript'>alert('Klant " . $customer_name . " verwijderd.');</script>";
}

?>

<!-- Hier komt de content -->
<div id="content" class="container">

	 <div class="table-header-container">
		<h2 class="tabel-header">Klantenoverzicht</h2>
		<a href="customercreate.php">Nieuwe klant aanmaken</a>
	</div>
	<table>
		<thead>
			<tr>
				<th>Klantnaam</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach (get_customerlist() as $customer) : ?>
			<tr>
				<td><?=$customer->customer_name; ?></td>
				<td>
					<a href="customeredit.php?id=<?= $customer->get_customer_id() ?>">
						<i class="material-icons table-icons">mode_edit</i>
					</a>
				</td>
				<td>
					<form id="delete-<?= $customer->get_customer_name(); ?>" action="customerlist.php" method="post">
						<input type="hidden" name="action" value="delete_customer" />
						<input type="hidden" name="customer_id" value="<?=$customer->get_customer_id(); ?>" />
						<input type="hidden" name="customer_name" value="<?=$customer->get_customer_name(); ?>" />
					</form>
					<a onclick="show_modal('<?= $customer->get_customer_name(); ?>', 'delete-<?= $customer->get_customer_name(); ?>')">
						<i class="material-icons table-icons">delete</i>
					</a>
				</td>
				<!-- <td><a href="#edit-<? // =$user->username; ?>"></a><a href="#delete-<? // =$user->username; ?>"></a></td> -->
			</tr>
			<?php endforeach; ?>
		
		</tbody>
	</table>
</div>

<div class="modal" id="modal">
	<div id="modal-content">
		<div id="modal-title"><h1>Klant verwijderen</h1></div>
		<div id="modal-p"><p>Weet u zeker dat u <span id="modal-name"></span> wilt verwijderen?</p></div>
		<div id="button-container">
			<button id="modal-delete-button" class="verwijderen" form="" type="submit">Klant verwijderen</button>
			<button onClick="hide_modal()" class="annuleren">Annuleren</button>
		</div>
	</div>
</div>

<!-- <meta http-equiv="refresh" content="1801; login.php" /> -->

<!-- Default PHP footer -->
<script type="text/javascript" src="private/js/modal.js"></script>
<?php include(SHARED_PATH . '/footer.php')?>