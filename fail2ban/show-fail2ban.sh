#!/bin/bash
# This script goes through all subdirectories and runs the fail2ban commands,
# substituting <directory> with the actual subdirectory name.
# It skips the fail2ban-client command if the jail.d/<dir_name>.conf file contains 'enabled = false'
# with optional spaces or tabs around the 'enabled = false' part.

# Check the status of the fail2ban service
sudo systemctl status fail2ban

# Show the overall fail2ban status
sudo fail2ban-client status

# Loop through each subdirectory and check for the enabled status in jail.d/<dir_name>.conf
for dir in */; do
    dir_name=$(basename "$dir")
    conf_file="$dir/jail.d/$dir_name.conf"
    
    # Check if the configuration file exists and contains 'enabled = false' with flexible spaces/tabs
    if [ -f "$conf_file" ] && egrep -q '^[[:space:]]*enabled[[:space:]]*=[[:space:]]*false' "$conf_file"; then
        echo "Skipping $dir_name as it is disabled in $conf_file"
    else
        echo "Checking fail2ban status for $dir_name..."
        sudo fail2ban-client status "$dir_name"
    fi
done

# Display the iptables rules
sudo iptables -L -n -v

