#!/bin/bash

# Directory to list
dir="/mnt/c/Users/pagec/Downloads/"

# Check if the directory exists
if [ ! -d "$dir" ]; then
    echo "Directory '$dir' does not exist."
    exit 1
fi

# List the first 10 files by last modification time (-c)
ls -c "$dir" | head -n 10

