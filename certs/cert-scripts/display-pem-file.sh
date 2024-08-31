#!/bin/bash

# This script displays the contents of a certificate file in a readable format.
# Usage: ./script_name <example-com>

# Check if exactly one argument is passed
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 <example-com>"
    exit 1
fi

# Get the base name from the command-line argument
basename="$1"

# Define the certificate file name based on the provided base name
cert_file="${basename}.cert.pem"

# Check if the certificate file exists
if [ ! -f "$cert_file" ]; then
    echo "Error: Certificate file '$cert_file' not found!"
    exit 1
fi

# Display the contents of the certificate file
openssl x509 -in "$cert_file" -text -noout

# Check if the OpenSSL command was successful
if [ $? -eq 0 ]; then
    echo "Certificate file displayed successfully."
else
    echo "Error: Failed to display the certificate file."
    exit 1
fi

