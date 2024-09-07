#!/bin/bash

# Check if two arguments are provided
if [ "$#" -ne 2 ]; then
  echo "Usage: $0 <chain> <index>"
  exit 1
fi

CHAIN=$1   # First argument is the chain name (e.g., INPUT)
INDEX=$2   # Second argument is the rule number (1 onwards)

# Ensure the index is a positive number
if ! [[ "$INDEX" =~ ^[1-9][0-9]*$ ]]; then
  echo "Error: Index must be a positive integer."
  exit 1
fi

# Delete the rule from the chain at the specified index
iptables -D "$CHAIN" "$INDEX"

# Check if the deletion was successful
if [ $? -eq 0 ]; then
  echo "Successfully deleted rule $INDEX from chain $CHAIN."
else
  echo "Failed to delete rule $INDEX from chain $CHAIN."
fi

