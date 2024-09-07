#!/bin/bash
# This script runs fail2ban-regex on testlog.log using the filter from systemd-bads

./install.sh

if [ -f "testlog.log" ]; then
    fail2ban-regex testlog.log systemd-bads
else
    echo "Warning: testlog.log is missing. Test can't be run."
fi

