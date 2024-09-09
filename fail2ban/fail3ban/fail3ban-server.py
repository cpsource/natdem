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
import f3b_SectionParser
import f3b_ruleset
import f3b_config

#
# Config values can be overwritten by config.ctl
#
# default value of debug
debug = False
# default value of pretend.
pretend = False

#
# routine to fold None into False
#
def check_var(var):
    return var if isinstance(var, bool) else (False if var is None else var)
# Test cases
#print(check_var(True))    # True
#print(check_var(False))   # False
#print(check_var(None))    # False
#print(check_var(42))      # 42 (since var is not None or bool)
#print(check_var("hello")) # "hello" (since var is not None or bool)

if __name__ == "__main__":
    # Create a Config instance and load the config.ctl file
    configClass = f3b_config.Config('config.ctl')
    configData = configClass.get_config_data()
    
    # Get debug flag
    tmp_var = configData.get('debug')
    if tmp_var is not None:
        print(f"debugging for this session is set to {tmp_var}")
        debug = tmp_var
    else:
        print("debugging for this session is set to False")
    # Get pretend flag
    tmp_var = configData.get('pretend')
    if tmp_var is not None:
        print(f"pretending for this session is set to {tmp_var}")
        debug = tmp_var
    else:
        print(f"pretending for this session isset to {pretend}")
    # Get default_ban_time
    tmp_var = configData.get('default_ban_time')
    if tmp_var is not None:
        print(f"default ban time for this session is set to {tmp_var} minutes")
        default_ban_time = tmp_var
    else:
        default_ban_time = 1
        print(f"default ban time defaults to 1 minute")

    wl = f3b_whitelist.Whitelist(configData)
    wl.whitelist_init()
    print("Whitelisted IPs:", wl.get_whitelist())
