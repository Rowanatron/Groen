<!-- Default PHP header -->
<?php

require_once('private/path_constants.php');

$page_title = 'Customerlist';

require_once('private/functions.php');
require_once('customer_functions.php');
require_once('Customer.php');
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
		<a href="createcustomer">Nieuwe klant aanmaken</a>
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
					<form action="customeredit" method="post">
						<input type="hidden" name="customer_id" value="<?=$customer->customer_id; ?>"/>
						<input type="image" name="submit" src="public/img/edit_pencil.png" onmouseover="this.src='public/img/edit-hover.png';" onmouseout="this.src='public/img/edit_pencil.png';" border="0" alt="bewerk" style="width: 10%; height: 10%;" />
					</form>
				</td>
				<td>
					<form action="customerlist" method="post" onsubmit="return confirm('Weet u zeker dat u <?=$customer->customer_name; ?> wilt verwijderen?');">
						<input type="hidden" name="action" value="delete_customer" />
						<input type="hidden" name="customer_id" value="<?=$customer->customer_id; ?>" />
						<input type="hidden" name="customer_name" value="<?=$customer->customer_name; ?>" />
						<input type="image" src="public/img/delete.png" onmouseover="this.src='public/img/delete-hover.png';" onmouseout="this.src='public/img/delete.png';"border="0" alt="delete" style="width: 7%; height: 7%;" />
					</form>
				</td>
				<!-- <td><a href="#edit-<? // =$user->username; ?>"></a><a href="#delete-<? // =$user->username; ?>"></a></td> -->
			</tr>
			<?php endforeach; ?>
		
		</tbody>
	</table>
</div>

<div id="modal">
	<div id="modal-content">
		<div id="modal-title"><h1>Klant verwijderen</h1></div>
		<div id="modal-p"><p>Weet u zeker dat u de klant wilt verwijderen?</p></div>
		<div id="button-container">
			<button class="verwijderen">Klant verwijderen</button>
			<button class="annuleren">Annuleren</button>
		</div>
	</div>
</div>

<meta http-equiv="refresh" content="1801; /public/login.php" />

<!-- Default PHP footer -->
<?php include('private/shared/footer.php')?>