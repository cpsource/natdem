#!/bin/bash
# This script goes through all subdirectories and runs test.sh if it exists.
# It pushes into the directory, runs the test, and then pops back to the original directory.

for dir in */; do
    if [ -f "$dir/test.sh" ]; then
        echo "Found test.sh in $dir. Running the test..."
        pushd "$dir" > /dev/null
        ./test.sh
        popd > /dev/null
    else
        echo "No test.sh found in $dir. Skipping."
    fi
done

echo "All tests completed."

