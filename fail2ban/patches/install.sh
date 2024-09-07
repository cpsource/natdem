
#!/bin/bash

# Check if the script is run as root
if [ "$(id -u)" -ne 0 ]; then
    echo "This script must be run as root" >&2
    exit 1
fi

# Directory where the .conf files are located
DIR="$(pwd)"

# Iterate over each *.conf file in the current directory
for conf_file in "$DIR"/*.conf; do
    # Check if any .conf files exist
    if [ -e "$conf_file" ]; then
        # Get the base filename
        filename=$(basename "$conf_file")
        
        # Create a backup of the existing file in /etc/fail2ban/action.d with .orig extension
        cp "/etc/fail2ban/action.d/$filename" "$DIR/$filename.orig"
        
        # Copy the new conf file to /etc/fail2ban/action.d
        cp "$conf_file" "/etc/fail2ban/action.d/$filename"
        
        # Change the ownership to ubuntu:ubuntu
        chown ubuntu:ubuntu "/etc/fail2ban/action.d/$filename"
    else
        echo "No .conf files found in the current directory."
    fi
done

echo "Installation and backup complete."
