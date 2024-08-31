#!/bin/bash

# This script signs a Certificate Signing Request (CSR) to create a new certificate.
# Usage: ./script_name <example-com>

# Check if exactly one argument is passed
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 <example-com>"
    exit 1
fi

# Get the base name from the command-line argument
basename="$1"

# Define the input CSR and output certificate filenames based on the provided base name
csr_file="${basename}.csr.pem"
cert_file="${basename}.cert.pem"

# Check if the CSR file exists
if [ ! -f "$csr_file" ]; then
    echo "Error: CSR file '$csr_file' not found!"
    exit 1
fi

# Sign the CSR using the CA's certificate and key
openssl x509 -req -in "$csr_file" -CA test-it.cert.pem -CAkey test-it.key.pem -CAcreateserial -out "$cert_file" -days 28 -sha256

# Check if the OpenSSL command was successful
if [ $? -eq 0 ]; then
    echo "Certificate signed successfully:"
    echo "Certificate: $cert_file"
else
    echo "Error: Failed to sign the certificate."
    exit 1
fi

