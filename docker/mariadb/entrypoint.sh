#!/bin/bash
set -e

: ${MYSQL_UID:=`stat -c %u $MARIADATA`}
: ${MYSQ_GUID:=`stat -c %g $MARIADATA`}

if [ "`id -u mysql`" != "$MYSQL_UID" ]; then
    usermod -u $MYSQL_UID mysql || true
fi

if [ "`id -g mysql`" != "$MYSQ_GUID" ]; then
    groupmod -g $MYSQ_GUID mysql || true
fi

[ -d "$MARIADATA" ] ||  mkdir -p "$MARIADATA"
chown -R mysql:mysql "$MARIADATA"

./docker-entrypoint.sh $@