#!/bin/bash
# This script goes through all subdirectories and runs the fail2ban commands,
# substituting <directory> with the actual subdirectory name.
# It skips the fail2ban-client command if the jail.d/<dir_name>.conf file contains 'enabled = false'
# with optional spaces or tabs around the 'enabled = false' part.

# Check the status of the fail2ban service
sudo systemctl status fail2ban

# Show the overall fail2ban status
sudo fail2ban-client status

# Now show all the jails
# Get the list of jails from fail2ban-client status
jail_list=$(sudo fail2ban-client status | grep 'Jail list:' | cut -d':' -f2 | tr -d ' ')
# Convert jail list to an array by splitting on commas
IFS=',' read -r -a jails <<< "$jail_list"
# Loop through each jail and get its status
for jail in "${jails[@]}"; do
    echo "Checking status for jail: $jail"
    sudo fail2ban-client status "$jail"
    echo "---------------------------------"
done

# do a special because sshd doesn't use the std paths
#echo "Checking fail2ban status for sshd..."
#sudo fail2ban-client status sshd

# Display the iptables rules
sudo iptables -L -n -v
sudo ip6tables -L -n -v

