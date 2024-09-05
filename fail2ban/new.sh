#!/bin/bash
# This script takes one argument as a directory name.
# It creates the directory with that name, and inside it, creates two subdirectories: filter.d and jail.d.
# If the main directory already exists, the script will print an error and exit.
# After creating the directory structure, it copies /etc/fail2ban/filter.d/<name>.conf and /etc/fail2ban/jail.d/<name>.conf
# to the newly created filter.d and jail.d directories, respectively.
# If the filter.d or jail.d file doesn't exist, it is created with predefined content.
# It also creates a test.sh file to run fail2ban-regex if testlog.log exists in the top-level directory.
# Finally, it creates an install.sh script inside the new directory with the provided code.

# Check if exactly one argument is provided
if [ "$#" -ne 1 ]; then
    echo "Usage: $0 <directory-name>"
    exit 1
fi

# Get the directory name from the first argument
dir_name="$1"

# Check if the main directory already exists
if [ -d "$dir_name" ]; then
    echo "Error: Directory '$dir_name' already exists."
    exit 1
fi

# Create the main directory
if mkdir "$dir_name"; then
    echo "Directory '$dir_name' created."
else
    echo "Failed to create directory '$dir_name'."
    exit 1
fi

# Create the subdirectories filter.d and jail.d inside the new directory
if mkdir "$dir_name/filter.d" && mkdir "$dir_name/jail.d"; then
    echo "Subdirectories 'filter.d' and 'jail.d' created inside '$dir_name'."
else
    echo "Failed to create subdirectories."
    exit 1
fi

# Copy the filter.d and jail.d .conf files from /etc/fail2ban
filter_source="/etc/fail2ban/filter.d/${dir_name}.conf"
jail_source="/etc/fail2ban/jail.d/${dir_name}.conf"

# Check if the filter.d .conf file exists, otherwise create it with predefined content
if [ -f "$filter_source" ]; then
    sudo cp "$filter_source" "$dir_name/filter.d/"
    echo "Copied $filter_source to $dir_name/filter.d/"
else
    cat << 'EOF' | sudo tee "$dir_name/filter.d/${dir_name}.conf" > /dev/null
#
# apache-dta.conf
#

[INCLUDES]

#before = apache-common.conf

before = common.conf

[Definition]

failregex =

ignoreregex =
EOF
    echo "Created file with predefined content at $dir_name/filter.d/${dir_name}.conf"
fi

# Check if the jail.d .conf file exists, otherwise create it with custom content using the directory name
if [ -f "$jail_source" ]; then
    sudo cp "$jail_source" "$dir_name/jail.d/"
    echo "Copied $jail_source to $dir_name/jail.d/"
else
    cat << EOF | sudo tee "$dir_name/jail.d/${dir_name}.conf" > /dev/null
[${dir_name}]
enabled = true
#port = sshd
port = http,https
logpath = /var/log/apache2/error.log

# logtrails = reverse # This scans the file from the start

filter = ${dir_name}
maxretry = 1
findtime = 3600
bantime = 48h

action = iptables-multiport[name=${dir_name}, port="80,443", protocol=tcp]
EOF
    echo "Created jail.d configuration file with custom content at $dir_name/jail.d/${dir_name}.conf"
fi

# Create the test.sh file in the top-level directory if it doesn't exist
test_sh="$dir_name/test.sh"

if [ ! -f "$test_sh" ]; then
    cat << EOF > "$test_sh"
#!/bin/bash
# This script runs fail2ban-regex on testlog.log using the filter from ${dir_name}

if [ -f "testlog.log" ]; then
    fail2ban-regex testlog.log ${dir_name}
else
    echo "Warning: testlog.log is missing. Test can't be run."
fi

EOF
    chmod +x "$test_sh"
    echo "Created test.sh to run fail2ban-regex in the $dir_name directory."
fi

# Create the install.sh script in the new directory
install_script="$dir_name/install.sh"

cat << 'EOF' > "$install_script"
#!/bin/bash
# This script copies two files based on the current directory name to their respective destinations:
# 1. 'jail.d/<current_dir_name>.conf' to '/etc/fail2ban/jail.d/'
# 2. 'filter.d/<current_dir_name>.conf' to '/etc/fail2ban/filter.d/'
# Before copying, it checks if the file contents are different.
# If they are the same, the script does not perform the copy.

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
fi

# Check if file contents are different for filter.d
if cmp -s "$source_filter_file" "$destination_filter_file"; then
    echo "Contents of $source_filter_file and $destination_filter_file are the same. No copy performed."
else
    # Perform the copy for filter.d with sudo
    sudo cp "$source_filter_file" "$destination_filter_file"
    echo "File copied from $source_filter_file to $destination_filter_file."
fi
EOF

# Make the install.sh script executable
chmod +x "$install_script"
echo "Install script created at $install_script and made executable."

