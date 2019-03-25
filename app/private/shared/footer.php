    <footer>
  	</footer>
    <?php if ($pagename == "environment_create.php" || $pagename == "env_vm_relation_create.php" ): ?>
        <script type="text/javascript" src=<?php echo JS_PATH . "environment_create.js"?>></script>
    <?php endif;
	if ($pagename == "createuser.php"): ?>
	<script type="text/javascript" src=<?php echo JS_PATH . "user_crud.js"?>></script>
	<?php endif;
	if (!($pagename == "systemoverview.php")): ?>
	<meta http-equiv="refresh" content="1801; login" />
	<?php endif; ?>
  </body>
</html>