<!-- Pour se déconnecter -->
<?php
session_start();
session_destroy();
header('Location: login_membre.php');
exit();
?>
