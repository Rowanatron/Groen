<?php

require_once('../private/path_constants.php');
require_once(PRIVATE_PATH . '/functions.php');
require_once(PRIVATE_PATH . '/user_functions.php');
require_once(PRIVATE_PATH . '/authorisation_functions.php');

$page_title = 'System overview';

session_start();

is_logged_in();
session_expired();

include(SHARED_PATH . '/header.php');
// $welkom = 'Welkom, ' .$_SESSION["given_name"]. '. ';

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
}

?>

<!-- Hier komt de content -->
<div id="content" class="container">
    <?php 
    //  echo $welkom;
    echo isset($message) ? $message : '';
    unset($_SESSION['message']);
    ?>

</div>

<div id="test"><?php echo "hi" ?></div>

<script>
    var $test = $("#test");
    setInterval(function() {
        $test.load("./systemoverview.php #test");
    }, 3000);
</script>

<!-- <meta http-equiv="refresh" content="10; ./systemoverview.php" /> -->

<?php include(SHARED_PATH . '/footer.php') ?> 