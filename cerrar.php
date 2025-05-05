<?php
$_SESSION['login'] = false;
session_destroy();
session_abort();
header('Location: leads.php');
