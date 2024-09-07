#!/bin/bash

# Define the jail name
JAIL_NAME="foo"

# Create the directory structure for $JAIL_NAME
mkdir -p "$JAIL_NAME"/jail.d
mkdir -p "$JAIL_NAME"/filter.d

# Change to the newly created directory
cd "$JAIL_NAME" || { echo "Failed to change directory to $JAIL_NAME"; exit 1; }

# Create the jail configuration file in the jail directory
cat <<EOF > jail.d/foo.conf
[$JAIL_NAME]
enabled = true
filter = $JAIL_NAME
port = ssh
logpath = $(pwd)/testlog.log
bantime = 1h
findtime = 10m
maxretry = 3
action = iptables[name=SSH, port=ssh, protocol=tcp]
EOF

# Create the filter configuration file in the jail directory
cat <<EOF > filter.d/foo.conf
[Definition]
failregex = ^%(__prefix_line)sInvalid user .* from <HOST> port [0-9]+
ignoreregex =
EOF

# Create a test log file with the offending string
cat <<EOF > testlog.log
Sep 07 11:37:13 ip-172-26-10-222 sshd[60571]: Invalid user operator from 207.5.113.117 port 37860
EOF

# Create the test.sh file, replacing systemd-bads with foo
cat <<EOF > test.sh
#!/bin/bash
# This script runs fail2ban-regex on testlog.log using the filter from foo

./install.sh

if [ -f "testlog.log" ]; then
    fail2ban-regex testlog.log foo
else
    echo "Warning: testlog.log is missing. Test can't be run."
fi
EOF

# Make test.sh executable
chmod +x test.sh

# Add the install.sh script
cat <<'EOF' > install.sh
#!/bin/bash
# This script automates the process of copying two configuration files to their respective 
# Fail2ban directories based on the current directory name:
# 
# 1. Copies the file 'jail.d/<current_dir_name>.conf' to '/etc/fail2ban/jail.d/'
# 2. Copies the file 'filter.d/<current_dir_name>.conf' to '/etc/fail2ban/filter.d/'
#
# The script checks if the contents are different before copying.
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
EOF

# Make install.sh executable
chmod +x install.sh

# Create the README-foo.md file
cat <<EOF > README-foo.md
# Fail2ban Jail Configuration for 'foo'

## Purpose

This setup creates a custom Fail2ban jail called \`foo\` to protect your server from brute-force SSH login attempts using invalid usernames. The jail monitors your SSH logs for suspicious login attempts, focusing on entries where invalid users try to connect to the SSH service. Offending IP addresses are banned temporarily.

### Original String Example:

The following log entry from \`journalctl\` was identified as suspicious:

\`\`\`
Sep 07 11:37:13 ip-172-26-10-222 sshd[60571]: Invalid user operator from 207.5.113.117 port 37860
\`\`\`

This indicates that an invalid user ("operator") attempted to log in from IP \`207.5.113.117\`.

## What the Script Does

1. **Creates directories**: 
   - The \`foo\` directory and relevant configuration files.
   
2. **Populates Configuration Files**: 
   - \`jail.d.conf\` defines the behavior of the \`foo\` jail, and \`filter.d.conf\` provides the rules to detect invalid user attempts.

3. **Test Log**: 
   - A \`testlog.log\` file simulating failed login attempts is created for testing.

4. **Test and Install Scripts**:
   - \`test.sh\` runs \`fail2ban-regex\` to test the \`foo\` jail against the \`testlog.log\`.
   - \`install.sh\` automates copying the configuration files to the Fail2ban directories.

## Why This Matters

SSH brute-force attacks are common, and this configuration helps block IPs that try to exploit common or default usernames. This jail focuses on preventing attacks where invalid user logins are detected.

## How to Use

1. **Run the \`initiate-jail.sh\` script**: 
   - This will set up the jail configuration, test log, and helper scripts.

2. **Test the Configuration**:
   \`\`\`bash
   ./test.sh
   \`\`\`

3. **Install the Configuration**:
   \`\`\`bash
   sudo ./install.sh
   \`\`\`

EOF

# Provide success message
echo "Jail '$JAIL_NAME' has been successfully created in $(pwd), including testlog, test.sh, install.sh, and README-foo.md."

