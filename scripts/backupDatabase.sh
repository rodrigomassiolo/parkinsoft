#!/bin/bash
function backupDatabase() {
mysqldump -u higia -p'Server123' --opt parkinsoft > /var/www/html/parkinsoft/storage/app/dbBackups/parkinsoft.sql
}
VALOR=$( backupDatabase )
echo "$VALOR"
exit


 