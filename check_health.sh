#!/bin/bash

echo "--- 1. Checking PHP Syntax ---"
find . -name "*.php" -not -path "./vendor/*" -exec php -l {} \; | grep -v "No syntax errors detected"

echo -e "\n--- 2. Checking Directory Permissions ---"
ls -ld config src templates vendor

echo -e "\n--- 3. Verifying Essential Files ---"
FILES=( "vendor/autoload.php" "config/map.php" "config/global.php" "config/hub_main.php" )
for file in "${FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "✅ $file exists"
    else
        echo "❌ $file MISSING"
    fi
done

echo -e "\n--- 4. Refreshing Autoloader ---"
composer dump-autoload