#!/bin/bash

# This script creates a Certificate Signing Request (CSR) using a specified configuration file.
# Usage: ./script_name <example-com>

# Check if exactly one argument is passed
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 <example-com>"
    exit 1
fi

# Get the base name from the command-line argument
basename="$1"

# Define the config.conf file
conf_file="nonca-config"

# Define the configuration file name based on the provided base name
config_file="${conf_file}.conf"

# Define the output CSR filename based on the provided base name
csr_file="${basename}.csr.pem"

# Define key file
keyfile="${basename}.key.pem"

# Check if the config file exists
if [ ! -f "$config_file" ]; then
    echo "Error: Configuration file '$config_file' not found!"
    exit 1
fi

# Generate the CSR using OpenSSL
openssl req -config "$config_file" -new -sha256 -newkey rsa:4096 -nodes -days 29 -keyout "$keyfile" -out "$csr_file"

# Check if the OpenSSL command was successful
if [ $? -eq 0 ]; then
    echo "Certificate Signing Request (CSR) generated successfully:"
    echo "CSR: $csr_file"
else
    echo "Error: Failed to generate CSR."
    exit 1
fi

