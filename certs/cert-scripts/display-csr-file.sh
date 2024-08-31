#!/bin/bash

# This script displays the contents of a PEM file in a readable format.
# Usage: ./script_name <example-com>

# Check if exactly one argument is passed
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 <example-com>"
    exit 1
fi

# Get the base name from the command-line argument
basename="$1"

# Define the PEM file name based on the provided base name
pem_file="${basename}.csr.pem"

# Check if the PEM file exists
if [ ! -f "$pem_file" ]; then
    echo "Error: PEM file '$pem_file' not found!"
    exit 1
fi

# Display the contents of the PEM file
openssl req -in "$pem_file" -text -noout

# Check if the OpenSSL command was successful
if [ $? -eq 0 ]; then
    echo "PEM file displayed successfully."
else
    echo "Error: Failed to display the PEM file."
    exit 1
fi

