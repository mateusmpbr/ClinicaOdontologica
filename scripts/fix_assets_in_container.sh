#!/usr/bin/env bash
set -euo pipefail
cd /var/www/html

# Replace relative asset paths in system/ and public/
find system public -type f \( -name '*.php' -o -name '*.html' \) -print0 | xargs -0 -r perl -0777 -i -pe \
  "s{(?:\.{2}/)+vendor/}{/vendor/}g; s{(?:\.{2}/)+css/}{/css/}g; s{(?:\.{2}/)+js/}{/js/}g"

echo "\nRemaining relative references (if any):"
grep -RIn --exclude-dir=.git -e '\.\./vendor' -e '\.\./css' -e '\.\./js' system public || true

if command -v php >/dev/null 2>&1; then
  echo "\nRunning php -l across PHP files (showing failures)..."
  find . -type f -name '*.php' -print0 | xargs -0 -n1 php -l 2>&1 || true
else
  echo "\nphp not found inside container"
fi
