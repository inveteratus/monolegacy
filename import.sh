#!/bin/sh

cat schema.sql data.sql | docker exec -i monolegacy.mysql mysql -umonolegacy -psecret monolegacy 2>&1 | grep -v "Using a password on the command line interface can be insecure"

if [ -f "extra.sql" ]; then
    cat extra.sql | docker exec -i monolegacy.mysql mysql -umonolegacy -psecret monolegacy 2>&1 | grep -v "Using a password on the command line interface can be insecure"
fi
