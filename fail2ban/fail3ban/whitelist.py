#!/bin/python3
class Whitelist:
    def __init__(self):
        # Initialize an empty array to store whitelisted IPs
        self.whitelist = []

    def whitelist_init(self):
        # Open the whitelist.ctl file
        try:
            with open('whitelist.ctl', 'r') as file:
                for line in file:
                    # Remove any comment after # and strip whitespace
                    clean_line = line.split('#')[0].strip()
                    
                    # If the line contains an IP address, add it to the whitelist
                    if clean_line:
                        self.whitelist.append(clean_line)
        except FileNotFoundError:
            print("Error: whitelist.ctl file not found.")
        except Exception as e:
            print(f"An error occurred: {e}")

    def get_whitelist(self):
        # Return the list of whitelisted IPs
        return self.whitelist

    def is_whitelisted(self, ip_address):
        # Return True if the ip_address is in the whitelist, False otherwise
        return ip_address in self.whitelist

# Example usage
if __name__ == "__main__":
    wl = Whitelist()
    wl.whitelist_init()
    print("Whitelisted IPs:", wl.get_whitelist())

    # Example of checking if an IP is whitelisted
    test_ip = '192.168.1.1'
    if wl.is_whitelisted(test_ip):
        print(f"{test_ip} is whitelisted.")
    else:
        print(f"{test_ip} is not whitelisted.")

