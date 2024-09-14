import re

class previousJournalctl:
    def __init__(self, radix=5):
        self.radix = radix
        self.next_free_idx = 0
        self.free_list = [None] * radix
    
    def add_entry(self, string):
        # Regex to match the required components (jail, pid, ip-address)
        pattern = r"\S+\s+\S+\s+\S+\s+ip-\d+-\d+-\d+-\d+\s+(\S+)\[(\d+)\]:.*?(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})"
        match = re.search(pattern, string)
        
        if match:
            jail = match.group(1)
            pid = match.group(2)
            ip_address = match.group(3) if match.group(3) else None
            # Store the extracted values as a tuple (jail, pid, ip-address or None)
            self.free_list[self.next_free_idx] = (jail, pid, ip_address, string)
        else:
            # In case the string does not match the expected format, store None
            self.free_list[self.next_free_idx] = None
        
        # Update next_free_idx using modulus to wrap around
        self.next_free_idx = (self.next_free_idx + 1) % self.radix
    
    def prev_entry(self):
        if self.free_list[self.next_free_idx] is None:
            return (False, None)
        
        # Initialize prev_idx to next_free_idx - 1 modulus radix
        prev_idx = (self.next_free_idx - 1) % self.radix
        # Extract tmp_jail and tmp_pid from the entry at prev_idx
        tmp_jail, tmp_pid, _, _ = self.free_list[prev_idx]
        
        # Loop through the list looking for a match
        while True:
            # Decrement prev_idx by 1 modulus radix
            prev_idx = (prev_idx - 1) % self.radix
            
            # If prev_idx equals next_free_idx, stop and return False
            if prev_idx == self.next_free_idx:
                return (False, None)
            
            # Extract jail and pid from the entry at prev_idx
            if self.free_list[prev_idx] is not None:
                jail, pid, _, _ = self.free_list[prev_idx]
                
                # Compare the jail and pid values
                if jail == tmp_jail and pid == tmp_pid:
                    return (True, self.free_list[prev_idx])
            else:
                return (False, None)
    
    def show_entries(self):
        print("Current entries in free_list (from newest to oldest):")
        if all(entry is None for entry in self.free_list):
            print("No entries in free_list.")
            return
        
        idx = (self.next_free_idx - 1) % self.radix  # Start from the last entry
        count = 0
        
        while True:
            entry = self.free_list[idx]
            if entry is not None:
                print(f"Index {idx}: {entry}")
            else:
                break  # Stop when an empty (None) entry is encountered
            
            idx = (idx - 1) % self.radix
            count += 1
            if count >= self.radix:  # Ensure not to loop indefinitely
                break
    
    def __del__(self):
        self.free_list = None


# Main entry point for testing
if __name__ == "__main__":
    # Create an instance of previousJournalctl
    log_monitor = previousJournalctl(radix=5)
    
    # Test strings (six entries, with the last matching one of the earlier ones)
    test_entries = [
        "Sep 13 23:50:09 ip-172-26-10-222 sshd[12345]: 'sshd' executed by 192.168.1.1",
        "Sep 13 23:55:15 ip-172-26-10-222 apache2[67890]: 'apache2' executed by 10.0.0.5",
        "Sep 13 23:57:32 ip-172-26-10-222 nginx[98765]: 'nginx' executed by 172.16.0.7",
        "Sep 13 23:59:50 ip-172-26-10-222 mysql[45678]: 'mysql' executed by 192.168.2.2",
        "Sep 13 23:51:09 ip-172-26-10-222 xmlrpc.php[162826]: 'xmlrpc.php' executed by 118.193.57.62",
        # The last entry will match the fourth entry (mysql process)
        "Sep 14 00:01:12 ip-172-26-10-222 mysql[45678]: 'mysql' executed by 192.168.2.2"
    ]
    
    # Add each entry to the log monitor
    for entry in test_entries:
        log_monitor.add_entry(entry)
    
    # Show entries in free_list for debugging
    log_monitor.show_entries()
    
    # Now, call prev_entry and check if it returns the correct match
    result = log_monitor.prev_entry()
    
    # Print result
    if result[0]:
        print(f"Match found: {result[1]}")
    else:
        print("No match found")
    
    # Verify if it matches the fourth entry
    expected_result = ('mysql', '45678', '192.168.2.2', "Sep 13 23:59:50 ip-172-26-10-222 mysql[45678]: 'mysql' executed by 192.168.2.2")
    if result[1] == expected_result:
        print("Test passed! Correct match returned.")
    else:
        print("Test failed! Incorrect result.")

