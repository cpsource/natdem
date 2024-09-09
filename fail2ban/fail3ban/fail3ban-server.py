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
import f3b_config

# default value of debug, but can be overwritten by config.ctl
debug = False

if __name__ == "__main__":
    # Create a Config instance and load the config.ctl file
    config = f3b_config.Config('config.ctl')
    # Get debug flag
    tmp_debug = config.get_value('debug')
    if tmp_debug is not None:
        print(f"debugging for this session is set to {tmp_debug}")
        debug = tmp_debug
    else:
        print("debugging for this session is set to False")

    wl = f3b_whitelist.Whitelist()
    wl.whitelist_init()
    print("Whitelisted IPs:", wl.get_whitelist())
