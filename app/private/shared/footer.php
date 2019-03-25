    <footer>
  	</footer>
	<?php if ($pagename == "createuser.php"): ?>
	<script type="text/javascript" src=<?php echo JS_PATH . "UserJavascript.js"?>></script>
	<?php endif;
	if (!($pagename == "systemoverview.php")): ?>
	<meta http-equiv="refresh" content="1801; login" />
	<?php endif; ?>
  </body>
</html>