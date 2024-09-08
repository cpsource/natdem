# fail3ban-server

import sys
import os

#
# Allow our foundation classes to be loaded
#
# Get the absolute path of the current directory (the directory containing this script)
current_dir = os.path.dirname(os.path.abspath(__file__))
# Add the subdirectory to the system path
subdirectory_path = os.path.join(current_dir, 'lib')
sys.path.append(subdirectory_path)

# Now you can import modules from the subdirectory
import f3b_whitelist
import f3b_blacklist
import f3b_fail3baninit
import f3b_iptables
import f3b_match_rule
import f3b_parse_file
import f3b_ruleset

if __name__ == "__main__":
    wl = f3b_whitelist.Whitelist()
    wl.whitelist_init()
    print("Whitelisted IPs:", wl.get_whitelist())
