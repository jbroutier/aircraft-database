#!/bin/bash

database_name= # Set the database name
remote_folder= # Set the Box remote folder ID

file=/tmp/backup-$(date +%F-%H-%M-%S).sql.gz
mysqldump --hex-blob $database_name | gzip > $file
box files:upload --parent-id $remote_folder --quiet $file
rm $file
