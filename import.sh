#!/bin/sh
cat schema.sql | docker exec -i monolegacy.mysql mysql -umonolegacy -psecret monolegacy 2>&1 | grep -v "Using a password on the command line interface can be insecure"