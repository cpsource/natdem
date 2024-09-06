#!/bin/bash
# This script runs fail2ban-regex on testlog.log using the filter from sshd

if [ -f "testlog.log" ]; then
    fail2ban-regex testlog.log sshd
else
    echo "Warning: testlog.log is missing. Test can't be run."
fi

