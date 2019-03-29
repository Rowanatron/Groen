    <footer>
  	</footer>
        <script type="text/javascript" src="private/js/environment_create.js"></script>
        <script type="text/javascript" src="private/js/addInput.js"></script>
		
    <?php if ($pagename == "createuser"): ?>
	<script type="text/javascript" src="private/js/user_crud.js"></script>
	<?php endif; ?>

    <?php if (!($pagename == "systemoverview.php")) : ?>
	<script type="text/javascript" src="private/js/modal.js"></script>
    <?php endif; ?>
	
	<?php if ($pagename == "user.php"): ?>
		<script type="text/javascript" src="private/js/file_upload_input.js"></script>
	<?php endif; ?>
	
    <?php if (!($pagename == "systemoverview.php")): ?>
	<meta http-equiv="refresh" content="1801; login" />
	<?php endif; ?>
  </body>
</html>