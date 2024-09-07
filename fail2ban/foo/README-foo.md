# Fail2ban Jail Configuration for 'foo'

## Purpose

This setup creates a custom Fail2ban jail called `foo` to protect your server from brute-force SSH login attempts using invalid usernames. The jail monitors your SSH logs for suspicious login attempts, focusing on entries where invalid users try to connect to the SSH service. Offending IP addresses are banned temporarily.

### Original String Example:

The following log entry from `journalctl` was identified as suspicious:

```
Sep 07 11:37:13 ip-172-26-10-222 sshd[60571]: Invalid user operator from 207.5.113.117 port 37860
```

This indicates that an invalid user ("operator") attempted to log in from IP `207.5.113.117`.

## What the Script Does

1. **Creates directories**: 
   - The `foo` directory and relevant configuration files.
   
2. **Populates Configuration Files**: 
   - `jail.d.conf` defines the behavior of the `foo` jail, and `filter.d.conf` provides the rules to detect invalid user attempts.

3. **Test Log**: 
   - A `testlog.log` file simulating failed login attempts is created for testing.

4. **Test and Install Scripts**:
   - `test.sh` runs `fail2ban-regex` to test the `foo` jail against the `testlog.log`.
   - `install.sh` automates copying the configuration files to the Fail2ban directories.

## Why This Matters

SSH brute-force attacks are common, and this configuration helps block IPs that try to exploit common or default usernames. This jail focuses on preventing attacks where invalid user logins are detected.

## How to Use

1. **Run the `initiate-jail.sh` script**: 
   - This will set up the jail configuration, test log, and helper scripts.

2. **Test the Configuration**:
   ```bash
   ./test.sh
   ```

3. **Install the Configuration**:
   ```bash
   sudo ./install.sh
   ```

