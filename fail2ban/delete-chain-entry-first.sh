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

# Get the rule at the specified index so we can reinsert it
RULE=$(iptables -S "$CHAIN" | sed -n "${INDEX}p")

# Check if the rule exists
if [ -z "$RULE" ]; then
  echo "Error: Rule $INDEX in chain $CHAIN does not exist."
  exit 1
fi

# Delete the rule from the chain
iptables -D "$CHAIN" "$INDEX"

# Remove the `-A` part from the rule (which stands for append)
RULE=$(echo "$RULE" | sed 's/^-A/-I/')

# Re-insert the rule at the first position in the chain
eval "iptables $RULE"

# Check if the reinsertion was successful
if [ $? -eq 0 ]; then
  echo "Successfully moved rule to the first position in chain $CHAIN."
else
  echo "Failed to move rule to the first position in chain $CHAIN."
fi

