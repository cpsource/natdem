import re
import ipaddress

def extract_log_info(log_line):
    """
    Extracts jail name, sequence number, and IP address from a log entry in the given order:
    jail -> sequence number -> IP address. Each subsequent search starts after the previous match.

    Parameters:
        log_line (str): The log entry as a string.
        
    Returns:
        tuple: (jail, sequence_number, [ip_type, ip_address])
            - jail: The jail name (e.g., sshd).
            - sequence_number: The sequence number from [] (as a string).
            - ip_info: A list containing the type of IP ('ipv4' or 'ipv6') and the IP address. 
              If no IP is found, this is None.
    """
    # Regex for jail name (word before '[')
    jail_pattern = r"(\w+)\s*\["
    
    # Regex for sequence number inside []
    sequence_pattern = r"\[(\d+)\]"
    
    # Regex for IP address (IPv4 or IPv6) with word boundaries
    ip_pattern = r"\b((?:(?:\d{1,3}\.){3}\d{1,3})|(?:[a-fA-F0-9:]+))\b"
    
    # Start search from the beginning of the string
    current_position = 0
    
    # Step 1: Extract jail name (match up to the '[' but don't include it)
    jail_match = re.search(jail_pattern, log_line)
    jail = jail_match.group(1) if jail_match else None
    
    # Update the current position to just after the jail match
    if jail_match:
        current_position = jail_match.end() - 1  # Subtract 1 to handle overlap
    
    # Step 2: Extract sequence number (search only for digits inside brackets)
    sequence_match = re.search(sequence_pattern, log_line[current_position:])
    sequence_number = sequence_match.group(1) if sequence_match else None
    
    # Update the current position to just after the sequence number match
    if sequence_match:
        current_position += sequence_match.end() - 1  # Subtract 1 to handle overlap
        saved_current_position = current_position + 3 # skips the :<space>
       
    # Step 3: Extract IP address (start search after sequence number)
    ip_match = re.search(ip_pattern, log_line[current_position:])
    ip_info = None
    if ip_match:
        ip_str = ip_match.group(1)
        try:
            # Validate if it's a valid IP (IPv4 or IPv6)
            ip_obj = ipaddress.ip_address(ip_str)
            ip_type = "ipv6" if isinstance(ip_obj, ipaddress.IPv6Address) else "ipv4"
            ip_info = [ip_type, ip_str]
        except ValueError:
            # Not a valid IP address
            ip_info = None
    
    return jail, sequence_number, ip_info, saved_current_position

# Example usage
log_line = "Journalctl line: Sep 13 12:46:37 ip-172-26-10-222 sshd[172070]: error: kex_exchange_identification: Connection closed by remote host"
result = extract_log_info(log_line)
print(result)
starting_position = result[3]
print(log_line[starting_position:])

      
log_line1 = "Journalctl line: Sep 13 12:46:37 ip-172-26-10-222 sshd[172070]: Connection closed by 104.152.52.121 port 51587"
result = extract_log_info(log_line1)
print(result)
starting_position = result[3]
print(log_line1[starting_position:])

#log_line = "Sep 13 08:39:31 ip-172-26-10-222 sshd[169214]: error: kex_exchange_identification: Connection closed by remote host by 2a06:4880:1000::e port 59259"
#result = extract_log_info(log_line)
#print(result)

