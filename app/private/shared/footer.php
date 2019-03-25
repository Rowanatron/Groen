    <footer>
  	</footer>
	<?php if ($pagename == "createuser.php"): ?>
	<script type="text/javascript" src="../private/UserJavascript.js"></script>
	<?php endif;
	if (!($pagename == "systemoverview.php")): ?>
	<meta http-equiv="refresh" content="1801; ../public/login.php" />
	<?php endif; ?>
  </body>
</html>