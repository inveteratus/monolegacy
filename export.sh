#!/bin/sh
docker exec -t monolegacy.mysql mysqldump --no-data --no-tablespaces -umonolegacy -psecret monolegacy | \
       grep -v "Using a password on the command line interface can be insecure" | \
       sed "s/AUTO_INCREMENT=[0-9]\+//g" > schema.sql
