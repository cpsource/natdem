#!/bin/bash

# This script displays the contents of a private key file in a readable format.
# Usage: ./script_name <example-com>

# Check if exactly one argument is passed
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 <example-com>"
    exit 1
fi

# Get the base name from the command-line argument
basename="$1"

# Define the key file name based on the provided base name
key_file="${basename}.key.pem"

# Check if the key file exists
if [ ! -f "$key_file" ]; then
    echo "Error: Key file '$key_file' not found!"
    exit 1
fi

# Display the contents of the key file
openssl rsa -in "$key_file" -text -noout

# Check if the OpenSSL command was successful
if [ $? -eq 0 ]; then
    echo "Key file displayed successfully."
else
    echo "Error: Failed to display the key file."
    exit 1
fi

