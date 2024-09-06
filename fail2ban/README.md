# Extra fail2ban support

This guy allows us to manage our modifications to fail2ban with git.

./new.sh <name> creates a directory structure and some stub files
./run-all-tests.sh enters each subdirectory and runs that test

In each <name>, there is an ./install.sh that installs that particular entry.
In each <name>, there is an ./test.sh that will check your failregex if there is a testlog.log

## Workflow

The workflow is:
  1. do the new.sh for your new jail
  2. cd to that new directory, and edit files accordingly
  3. run the test via test.sh
  4. run install.sh 

## Notes

###Note: monitor_fail2ban.py can be run on a terminal. It monitors journalctl and checks that exceptions are covered by rules.

### Note: MAKE SURE you have alternative ip addresses into your host. A couple of times, I locked myself out by banning my development box.

You can get around a ban by
  1. use a vpn to come at the host from a different ip
  2. use the aws console ssh shell to get in
  3. always keep one terminal always logged into host.
  4. wait for the ban to timeout. During testing, you might want to use short bans.
  5. restore your host from backup. If you have access, bring up the kernel in maintenance mode
  6. before you start seriously testing, do the following. It overrides anything fail2ban can do for your development box.

```
  sudo iptables -I INPUT 1 -s <your-ip-address> -j ACCEPT
```

Then, to recover, get to host and scan journalctl to find when you last logged into your account.
Remember that ip address.

Next, run

```
  ./show_fail2ban.sh > /tmp/zz and find your <ip address>. Note which jail banned it.
```

If all else fails, shutdown fail2ban

```
  sudo systemctl stop fail2ban
```

Finally, unjail it with this command

```
  sudo fail2ban-client <jail-name> unbanip <ip address>
```

## sshd_conf

Note: I've included my sshd_conf file. You might diff it with yours to close down your
ssh. For example, I only allow certificate logins.

## Is all this worth it?

Yes! Any port you open to the outside world will be attacked one way or the other. I ran these fail2ban mods and
I had over a hundred ip addresses banned.

fail2ban only works after the first failed attempt, and only if you have a jail that detects that attempt.
Therefore, your underlying secuirty needs to be tight and you need to keep checking your logs.

fail2ban will stop password guessing, as after your first attempt, you end up in jail.
