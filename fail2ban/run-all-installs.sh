#!/bin/bash
# This script goes through all subdirectories and runs install.sh if it exists.
# It pushes into the directory, runs the install script, and then pops back to the original directory.

for dir in */; do
    if [ -f "$dir/install.sh" ]; then
        echo "Found install.sh in $dir. Running the install script..."
        pushd "$dir" > /dev/null
        ./install.sh
        popd > /dev/null
    else
        echo "No install.sh found in $dir. Skipping."
    fi
done

echo "All install scripts completed."

