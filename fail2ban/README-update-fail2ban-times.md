
# update-fail2ban-ban-times.py

## Purpose

The `update-fail2ban-ban-times.py` script is designed to simplify the administration of Fail2ban by allowing administrators to update the `bantime` setting across all relevant jail configuration files in bulk. This script is especially useful when you want to standardize or modify the ban time for all jails in Fail2ban without manually editing each configuration file.

## How it Works

- The script scans the current directory (`.`) for any subdirectories.
- If a subdirectory contains a `jail.d` directory, it checks for a `.conf` file named `<directory>.conf` within that `jail.d` folder.
- In each matching `.conf` file, the script looks for any line containing the `bantime =` directive (using regex) and replaces the old value with the new one provided as a command-line argument.
- The script ignores comments and only modifies uncommented lines that contain the `bantime` setting.

## Usage

```bash
python update-fail2ban-ban-times.py <new_bantime>
```

- `<new_bantime>`: The new ban time (in seconds) that you wish to apply to all jails.

For example, to set the `bantime` to 600 seconds:

```bash
python update-fail2ban-ban-times.py 600
```

## Prerequisites

- Python 3.x installed.
- The script should be run from a directory where the Fail2ban configuration subdirectories exist.
- You must have the necessary permissions to modify the configuration files.

## Features

- **Regex-based matching**: The script uses a regular expression to identify lines containing `bantime`, ensuring flexibility.
- **Comment handling**: The script ignores lines that are commented out, making sure only active settings are modified.

## Benefits

- **Efficiency**: Update all ban times in Fail2ban configuration files at once, saving time and effort.
- **Consistency**: Ensure all jails are using the same ban time, making administration simpler and more standardized.

## License

This script is free to use and modify.
