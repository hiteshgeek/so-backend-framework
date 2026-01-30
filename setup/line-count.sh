#!/bin/bash
#
# Line Count - SO Backend Framework
# Counts lines of code excluding vendor, tests, docs, and hidden files
#

find . -type f \
  -not -path "*/.*" \
  -not -path "*/node_modules/*" \
  -not -path "*/vendor/*" \
  -not -path "*/tests/*" \
  -not -path "*/docs/*" \
  -not -name "composer.lock" \
  -exec wc -l {} + | sort -nr | nl -w2 -s'. '
