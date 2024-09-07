#!/usr/bin/python3

import os
import sys
import re

def update_bantime(new_bantime):
    # Regex to match the bantime line
    bantime_regex = re.compile(r'^.*bantime\s*=\s*.*')

    # Get the current working directory
    current_dir = os.getcwd()

    # Loop through all items in the current directory
    for directory in os.listdir(current_dir):
        # Check if the item is a directory
        dir_path = os.path.join(current_dir, directory)
        if os.path.isdir(dir_path):
            # Check if jail.d directory exists inside
            jail_d_path = os.path.join(dir_path, 'jail.d')
            if os.path.isdir(jail_d_path):
                # Construct the config file path
                conf_file = os.path.join(jail_d_path, f'{directory}.conf')
                if os.path.isfile(conf_file):
                    # Read and modify the file
                    with open(conf_file, 'r') as file:
                        lines = file.readlines()

                    # Update the bantime line using regex
                    with open(conf_file, 'w') as file:
                        for line in lines:
                            # Skip comments
                            line_without_comment = line.split('#')[0].strip()

                            if bantime_regex.match(line_without_comment):
                                file.write(f'bantime = {new_bantime}\n')
                            else:
                                file.write(line)

                    print(f"Updated bantime in {conf_file}")

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python update-fail2ban-ban-times.py <new_bantime>")
        sys.exit(1)

    new_bantime = sys.argv[1]
    update_bantime(new_bantime)

