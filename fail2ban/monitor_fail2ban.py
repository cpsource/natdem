#!/usr/bin/env python3

import os
import subprocess
import tempfile
import re

# Path to the temporary file in /tmp
temp_file = tempfile.NamedTemporaryFile(delete=False, dir='/tmp', mode='w', prefix='journal_', suffix='.log')

# Function to delete temporary files created by the script
def clean_temp_files():
    if os.path.exists(temp_file.name):
        os.remove(temp_file.name)
    #print("Cleaned up temporary files.")

# Function to check if a jail is enabled by searching for 'enabled = true'
import re

# Function to check if a jail is enabled by searching for 'enabled = true' or 'enabled = false'
import re

# Function to check if a jail is enabled by searching for 'enabled = true' or 'enabled = false'
def is_jail_enabled(dir_name):
    jail_conf_file = os.path.join(dir_name, 'jail.d', f'{dir_name}.conf')
    
    # Debug: print the file being tested
    # print(f"Testing file: {jail_conf_file}")
    
    if os.path.isfile(jail_conf_file):
        with open(jail_conf_file, 'r') as conf:
            for line in conf:
                # Remove comments (anything after #) and strip leading/trailing whitespace
                line = line.split('#', 1)[0].strip()
                
                # Debug: print the processed line after removing comments and trimming
                # print(f"Processed line: {line}")
                
                # Check for 'enabled = true' with flexible spaces/tabs using regex
                if re.match(r'.*enabled.*=.*true.*', line):
                    # print("Found 'enabled = true'. Stopping search.")
                    return True  # Stop searching and return True
                
                # Check for 'enabled = false' and stop if found
                elif re.match(r'.*enabled.*=.*false.*', line):
                    # print("Found 'enabled = false'. Stopping search.")
                    return False  # Stop searching and return False
                
    return False  # Default to False if no 'enabled = true' was found


# Function to process each line from journalctl
def process_journalctl_line(line):
    # Write the line to the temporary file
    with open(temp_file.name, 'a') as tempf:
        tempf.write(line)
    
    # Flag to track if a match was found
    match_found = False

    # Iterate over each subdirectory and run fail2ban-regex
    for dir in os.listdir('.'):
        if os.path.isdir(dir):
            # Check if jail is enabled
            if is_jail_enabled(dir):
                # Create a temporary file for fail2ban-regex output
                with tempfile.NamedTemporaryFile(delete=False, mode='w', prefix='fail2ban_', suffix='.log') as regex_temp_file:
                    regex_temp_file_path = regex_temp_file.name
                
                # Run fail2ban-regex and redirect the output to the temp file
                try:
                    subprocess.run(['fail2ban-regex', temp_file.name, dir],
                                   stdout=open(regex_temp_file_path, 'w'),
                                   stderr=subprocess.STDOUT,
                                   check=True)
                    
                    # Check the regex temp file for success (0 ignored, 1 matched)
                    with open(regex_temp_file_path, 'r') as f:
                        regex_output = f.read()
                        if '0 ignored' in regex_output and '1 matched' in regex_output:
                            print(f"OK: {dir}")
                            match_found = True

                except subprocess.CalledProcessError:
                    pass  # Fail silently on failure (no output)

                finally:
                    # Cleanup: remove the regex output temp file
                    os.remove(regex_temp_file_path)
            #else:
                #print(f"Skipping {dir}: Jail is not enabled")
    
    # If no match was found, remain silent as per the request

# Start journalctl -f
journalctl_proc = subprocess.Popen(['journalctl', '-f'], stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)

try:
    # Process each line from journalctl -f
    for line in journalctl_proc.stdout:
        # Clean up previous temporary files
        clean_temp_files()

        # Print the journalctl line before processing
        print(f"Journalctl line: {line.strip()}")
        process_journalctl_line(line)

except KeyboardInterrupt:
    print("Script interrupted. Exiting...")
finally:
    # Cleanup: close the temporary file and delete it
    temp_file.close()
    os.remove(temp_file.name)
    print(f"Temporary file {temp_file.name} removed.")

