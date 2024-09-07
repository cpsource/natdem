
# Fail2ban Jail Configuration for 'foo'

## Purpose

This setup creates a custom Fail2ban jail called `foo` to protect your server from brute-force SSH login attempts using invalid usernames. The jail monitors your SSH logs for suspicious login attempts, specifically focusing on log entries where invalid users are trying to connect to the SSH service. If multiple failed attempts occur within a short period, the offending IP address is temporarily banned from accessing the server.

### Original String Example:

The following log entry from `journalctl` was identified as suspicious and serves as the trigger for this jail:

```
Sep 07 11:37:13 ip-172-26-10-222 sshd[60571]: Invalid user operator from 207.5.113.117 port 37860
```

This indicates that an invalid user ("operator") attempted to log in from the IP address `207.5.113.117` using port `37860`. The purpose of this jail is to block such attempts.

## What the Script Does

The `initiate-jail.sh` script automates the creation and configuration of the `foo` jail in the Fail2ban system. Specifically, it does the following:

1. **Creates Necessary Directories**: 
   - It ensures the `jail.d` and `filter.d` directories exist in the current Fail2ban directory.

2. **Populates the `jail.d/foo.conf` file**:
   - This file defines the behavior of the `foo` jail, including the log file to monitor, the number of failed attempts before banning, and the ban duration.

   Example of `jail.d/foo.conf`:
   ```ini
   [foo]
   enabled = true
   filter = foo
   port = ssh
   logpath = /var/log/auth.log
   bantime = 1h
   findtime = 10m
   maxretry = 3
   action = iptables[name=SSH, port=ssh, protocol=tcp]
   ```

3. **Populates the `filter.d/foo.conf` file**:
   - This file defines the regular expression that identifies the log entries Fail2ban should watch for, specifically those involving invalid SSH login attempts.

   Example of `filter.d/foo.conf`:
   ```ini
   [Definition]
   failregex = ^%(__prefix_line)sInvalid user .* from <HOST> port [0-9]+
   ignoreregex =
   ```

## Why This Is Important

SSH brute-force attacks are a common method used by attackers to gain unauthorized access to systems. By configuring Fail2ban to detect and block IP addresses after multiple failed login attempts, you can effectively mitigate this type of attack.

This setup focuses on preventing invalid user logins like the one shown in the original string (`Invalid user operator from ...`). After 3 failed attempts, the offending IP will be blocked from further SSH access for 1 hour, improving the security of your server.

## Usage

1. Run the `initiate-jail.sh` script in the root directory of your Fail2ban installation to create the `foo` jail.
2. Restart Fail2ban to apply the new jail:
   ```bash
   sudo systemctl restart fail2ban
   ```
