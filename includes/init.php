<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

session_start();

if (check_update_time()) {
    fetch_news();
}
?>