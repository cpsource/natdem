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
  sudo iptables -I INPUT 1 -s `./who-am-i.py` -j ACCEPT
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

## Strange unresolved error messages

### Chinese hackers ???

This from journalctl -f log. It happened just as I opened the mariaDB port to the world (Security types
would say this is a really BAD idea, btw). ChatGPT thought it was Chinese hackers. Is it? And, my home
box is on starlink. So the Chinese must have been monitoring my traffic. I was saved because mariaDB
comes with Reverse DNS enabled, and couldn't lookup the IP.

mariadbd[31886]: 2024-09-06 11:49:52 31 [Warning] Host name 'customer.nwyynyx1.pop.starlinkisp.net' could not be resolved: Name or service not known

### Probes of port ssh

I've been running monitor_fail2ban.py. It watches journalctl -f, and tests against my fail2ban jail set.
Here, we can see someone from IP 117.232.192.137, user 'user', tried to connect to sshd (port 22).
But HA, I had two jails that cought the attempt, systemd-bads, and sshd both put this guy in jail.

Journalctl line: Sep 06 11:56:55 ip-172-26-10-222 sshd[32446]: Invalid user user from 117.232.192.137 port 48763
OK: systemd-bads
OK: sshd

I did a dig -x 117.232.192.137 and received the following. Note the PTR record should have had it's IP but it did not.
Next, I'm going to try to write to hostmaster@bsnl.in and complain. (The mail bounced)

; <<>> DiG 9.18.28-0ubuntu0.22.04.1-Ubuntu <<>> -x 117.232.192.137
;; global options: +cmd
;; Got answer:
;; ->>HEADER<<- opcode: QUERY, status: NXDOMAIN, id: 33712
;; flags: qr rd ra; QUERY: 1, ANSWER: 0, AUTHORITY: 1, ADDITIONAL: 1

;; OPT PSEUDOSECTION:
; EDNS: version: 0, flags:; udp: 512
;; QUESTION SECTION:
;137.192.232.117.in-addr.arpa.  IN      PTR

;; AUTHORITY SECTION:
232.117.in-addr.arpa.   1800    IN      SOA     ns11.bsnl.in. hostmaster.bsnl.in. 2023110701 3600 600 3600000 3600

;; Query time: 299 msec
;; SERVER: 10.255.255.254#53(10.255.255.254) (UDP)
;; WHEN: Fri Sep 06 09:11:56 EDT 2024
;; MSG SIZE  rcvd: 116
