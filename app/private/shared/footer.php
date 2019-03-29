	<footer>
	</footer>
	<script type="text/javascript" src="private/js/modal.js"></script>
	
	<?php if ($pagename == "environmentcreate.php" || $pagename == "environmentedit.php") : ?>
		<script type="text/javascript" src="private/js/environment_crud.js"></script>
		<script type="text/javascript" src="private/js/addInput.js"></script>
	<?php endif; ?>
    	
    <?php if ($pagename == "createuser"): ?>
		<script type="text/javascript" src="private/js/user_crud.js"></script>
	<?php endif; ?>
	
	<?php if ($pagename == "user.php"): ?>
		<script type="text/javascript" src="private/js/file_upload_input.js"></script>
		<script type="text/javascript" src="private/js/equal_passwords.js"></script>
		<script type="text/javascript" src="private/js/user_crud.js"></script>
	<?php endif; ?>
	
    <?php if (!($pagename == "systemoverview.php")): ?>
		<meta http-equiv="refresh" content="1801; login" />
	<?php endif; ?>
  
	</body>
</html>