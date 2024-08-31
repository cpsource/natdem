#!/bin/bash
# Create a self-signed certificate

# Check if exactly one argument is passed
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 <example-com>"
    exit 1
fi

# Get the base name from the command-line argument
basename="$1"

# Define the output filenames based on the provided base name
key_file="${basename}.key.pem"
cert_file="${basename}.cert.pem"

# Check if the config file exists
config_file="nonca-config.conf"
if [ ! -f "$config_file" ]; then
    echo "Error: Configuration file '$config_file' not found!"
    exit 1
fi

# Generate the key and certificate using OpenSSL
openssl req -config "$config_file" -new -x509 -sha256 -newkey rsa:4096 -nodes -keyout "$key_file" -days 27 -out "$cert_file"

# Check if the OpenSSL command was successful
if [ $? -eq 0 ]; then
    echo "Certificate and key generated successfully:"
    echo "Key:  $key_file"
    echo "Cert: $cert_file"
else
    echo "Error: Failed to generate certificate and key."
    exit 1
fi

