<?php
$log_file = '/home/eksan/logs/log.txt';

// Pastikan file ada
if (file_exists($log_file)) {
    echo nl2br(file_get_contents($log_file));
} else {
    echo "Log file tidak ditemukan.";
}
?>
