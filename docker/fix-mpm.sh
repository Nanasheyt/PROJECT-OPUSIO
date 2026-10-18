#!/bin/sh
# Make mpm_prefork the ONLY Apache MPM that is loaded.
#
# php:*-apache runs PHP as mod_php, which needs mpm_prefork. On Railway the
# container can start with mpm_event / mpm_worker enabled as well, and Apache
# then refuses to start and the deploy crash-loops with:
#   AH00534: apache2: Configuration error: More than one MPM loaded.
# Disabling the extra MPMs in the Dockerfile (build time) is not enough, so
# docker/start.sh runs this on every container start, right before Apache.
#
# Usage: fix-mpm.sh [apache-config-dir]      (default: /etc/apache2)
set -eu

DIR="${1:-/etc/apache2}"
ENABLED="$DIR/mods-enabled"
AVAILABLE="$DIR/mods-available"

if [ ! -f "$AVAILABLE/mpm_prefork.load" ]; then
    echo "fix-mpm: $AVAILABLE/mpm_prefork.load not found - is this the Debian apache2 layout?" >&2
    exit 1
fi
mkdir -p "$ENABLED"

# 1. Remove every enabled MPM (event, worker, itk, even prefork), whether it is
#    a symlink or a real file, so we always start from a clean slate.
rm -f "$ENABLED"/mpm_*.load "$ENABLED"/mpm_*.conf

# 2. Enable prefork, and only prefork.
ln -s ../mods-available/mpm_prefork.load "$ENABLED/mpm_prefork.load"
if [ -f "$AVAILABLE/mpm_prefork.conf" ]; then
    ln -s ../mods-available/mpm_prefork.conf "$ENABLED/mpm_prefork.conf"
fi

# 3. Neutralise any other MPM LoadModule line that sits in a config file that
#    Apache really reads (mods-available is not read unless it is linked above).
for f in "$DIR/apache2.conf" "$DIR"/conf-enabled/*.conf "$DIR"/sites-enabled/*.conf "$ENABLED"/*.load; do
    [ -f "$f" ] || continue
    grep -Eq '^[[:space:]]*LoadModule[[:space:]]+mpm_(event|worker|itk)_module' "$f" || continue
    sed -i -E 's/^([[:space:]]*LoadModule[[:space:]]+mpm_(event|worker|itk)_module)/# disabled by fix-mpm.sh: \1/' "$f"
    echo "fix-mpm: commented out a stray MPM LoadModule in $f"
done

echo "fix-mpm: enabled MPM modules:"
ls -l "$ENABLED" | grep 'mpm_' || true
