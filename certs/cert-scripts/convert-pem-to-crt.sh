#!/bin/bash
# Convert a .pem to a .crt file
# Check if exactly one argument is passed
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 <yourfile.pem>"
    exit 1
fi

# Get the input file from the command-line argument
input_file="$1"

# Check if the input file exists
if [ ! -f "$input_file" ]; then
    echo "Error: File '$input_file' not found!"
    exit 1
fi

# Extract the filename without the extension
filename="${input_file%.*}"

# Define the output file by appending .crt to the base filename
output_file="${filename}.crt"

# Convert the .pem file to .crt using OpenSSL
openssl x509 -outform der -in "$input_file" -out "$output_file"

# Check if the conversion was successful
if [ $? -eq 0 ]; then
    echo "Conversion successful: '$output_file' created."
else
    echo "Error: Conversion failed."
    exit 1
fi

