<?php echo (new PDO("mysql:host=localhost;dbname=seubanco;charset=utf8","usuario","senha"))->query("SHOW TABLES")->fetchColumn(); ?>
