#!/usr/bin/env bash
set -euo pipefail

mkdir -p scripts

# Patch files that still reference relative asset paths
grep -RIl --exclude-dir=.git -e '\.\./vendor' -e '\.\./css' -e '\.\./js' system public | while IFS= read -r f; do
  echo "Patching $f"
  sed -i \
    -e "s|../../../vendor/|/vendor/|g" \
    -e "s|../../vendor/|/vendor/|g" \
    -e "s|../vendor/|/vendor/|g" \
    -e "s|../../../css/|/css/|g" \
    -e "s|../../css/|/css/|g" \
    -e "s|../css/|/css/|g" \
    -e "s|../../../js/|/js/|g" \
    -e "s|../../js/|/js/|g" \
    -e "s|../js/|/js/|g" "$f" || echo "Failed to patch $f"
done

echo
echo "Remaining relative references (if any):"
grep -RIn --exclude-dir=.git -e '\.\./vendor' -e '\.\./css' -e '\.\./js' system public || true

echo
echo "Files with suspect missing-quote patterns (inspect manually):"
grep -RIl --exclude-dir=.git -e 'href/vendor' -e 'src/vendor' system public || true

echo
echo "Done. If output shows no remaining occurrences, asset paths are updated."