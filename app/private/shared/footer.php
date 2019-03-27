    <footer>
  	</footer>
        <script type="text/javascript" src=<?php echo JS_PATH . "/environment_create.js"?>></script>
        <script type="text/javascript" src=<?php echo JS_PATH . "/addInput.js"?>></script>
    <?php if ($pagename == "createuser"): ?>
	<script type="text/javascript" src=<?php echo JS_PATH . "user_crud.js"?>></script>
	<?php endif; ?>
    <?php if (!($pagename == "systemoverview.php")): ?>
	<meta http-equiv="refresh" content="1801; login" />
	<?php endif; ?>
  </body>
</html>