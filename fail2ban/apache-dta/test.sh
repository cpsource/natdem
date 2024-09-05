#!/bin/bash
# This script runs fail2ban-regex on testlog.log using the filter from apache-dta

if [ -f "testlog.log" ]; then
    fail2ban-regex testlog.log apache-dta
else
    echo "Warning: testlog.log is missing. Test can't be run."
fi

