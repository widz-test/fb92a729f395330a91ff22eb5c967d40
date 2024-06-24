#!/bin/sh

# Run the PHP built-in server
php -S 0.0.0.0:8000 server.php &

# Run the cron job in the background
php cron/cron.php