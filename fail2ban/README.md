# fail2ban support

This guy allows us to manage our modifications to fail2ban with git.

./new.sh <name> creates a directory structure and some stub files
./run-all-tests.sh enters each subdirectory and runs that test

In each <name>, there is an ./install.sh that installs that particular entry.
In each <name>, there is an ./test.sh that will check your failregex if there is a testlog.log

