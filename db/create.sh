#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE mueveme_test;"
    psql -U postgres -c "CREATE USER mueveme PASSWORD 'mueveme' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists mueveme
    sudo -u postgres dropdb --if-exists mueveme_test
    sudo -u postgres dropuser --if-exists mueveme
    sudo -u postgres psql -c "CREATE USER mueveme PASSWORD 'mueveme' SUPERUSER;"
    sudo -u postgres createdb -O mueveme mueveme
    sudo -u postgres psql -d mueveme -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O mueveme mueveme_test
    sudo -u postgres psql -d mueveme_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:mueveme:mueveme"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
