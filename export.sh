#!/bin/sh
docker exec -t monolegacy.mysql mysqldump --no-tablespaces -umonolegacy -psecret monolegacy | grep -v "Using a password on the command line interface can be insecure" > schema.sql
