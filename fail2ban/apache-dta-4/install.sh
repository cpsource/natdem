#!/bin/bash
# This script automates the process of copying two configuration files to their respective 
# Fail2ban directories based on the current directory name:
# 
# 1. Copies the file 'jail.d/<current_dir_name>.conf' to '/etc/fail2ban/jail.d/'
# 2. Copies the file 'filter.d/<current_dir_name>.conf' to '/etc/fail2ban/filter.d/'
#
# The script checks if the contents of the source and destination files differ before copying.
# If the contents are identical, no copying is performed.
#
# After copying, the ownership of the copied files is set to root:root.

# Get the current directory name
current_dir_name=$(basename "$PWD")

# Define the source and destination paths for jail.d and filter.d using the current directory name
source_jail_file="jail.d/${current_dir_name}.conf"
destination_jail_file="/etc/fail2ban/jail.d/${current_dir_name}.conf"

source_filter_file="filter.d/${current_dir_name}.conf"
destination_filter_file="/etc/fail2ban/filter.d/${current_dir_name}.conf"

# Check if file contents are different for jail.d
if cmp -s "$source_jail_file" "$destination_jail_file"; then
    echo "Contents of $source_jail_file and $destination_jail_file are the same. No copy performed."
else
    # Perform the copy for jail.d with sudo
    sudo cp "$source_jail_file" "$destination_jail_file"
    echo "File copied from $source_jail_file to $destination_jail_file."
    # Set ownership to root:root
    sudo chown root:root "$destination_jail_file"
    echo "Ownership of $destination_jail_file set to root:root."
fi

# Check if file contents are different for filter.d
if cmp -s "$source_filter_file" "$destination_filter_file"; then
    echo "Contents of $source_filter_file and $destination_filter_file are the same. No copy performed."
else
    # Perform the copy for filter.d with sudo
    sudo cp "$source_filter_file" "$destination_filter_file"
    echo "File copied from $source_filter_file to $destination_filter_file."
    # Set ownership to root:root
    sudo chown root:root "$destination_filter_file"
    echo "Ownership of $destination_filter_file set to root:root."
fi

