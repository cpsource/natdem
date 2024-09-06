
# **Architectural Document: Dynamic IP Whitelisting in iptables for Remote Developer Access**

## **Overview**
The goal of this architecture is to allow developers to dynamically update their public IP address in the `iptables` firewall rules on a remote server. This ensures that they don’t get locked out due to changing IP addresses (for example, when working from different networks or after reconnecting to the internet).

## **Components**
1. **Developer’s Local Machine**:
   - The machine where the developer works, which is responsible for detecting its own public IP and initiating an SSH connection to the remote server to update the firewall.

2. **Remote Server**:
   - The production or development server where the developer needs access. It runs the `iptables` firewall and requires the developer’s IP to be added as a whitelisted address in the `INPUT` chain.

3. **Public IP Detection Script**:
   - A script (`who-am-i.py`) running on the developer’s local machine to detect their public IP address.

4. **SSH & iptables**:
   - The Secure Shell (SSH) protocol is used to securely execute commands on the remote server. The `iptables` firewall on the remote server manages access control.

---

## **Architecture Diagram**

```
[Developer Machine]  ----(SSH with SendEnv)---->  [Remote Server]
     |                                               |
     | Detects public IP via who-am-i.py             | Updates iptables rules to allow access
     |                                               | from Developer's IP
     |
     v
Detects & sets Developer_IP
```

---

## **Workflow**

### 1. **Detect Developer’s Public IP**
The developer’s machine runs a Python script (`who-am-i.py`) to detect its public IP address.

```bash
python3 ~/natdem/fail2ban/who-am-i.py
```

This script outputs the developer's current public IP in the format:

```
Your public IP address is: <IP>
```

### 2. **Set and Export IP Address**
Once the IP address is extracted from the script, the Bash script on the developer’s machine exports it as `Developer_IP`.

```bash
export Developer_IP="<detected_public_ip>"
```

### 3. **Establish SSH Connection and Update iptables**
Using SSH, the developer connects to the remote server and sends the `Developer_IP` variable using the `SendEnv` option. A script on the remote server will read this environment variable and update the `iptables` rules to whitelist the developer’s IP address.

### 4. **Remote iptables Update**
The remote server runs a script that checks if the developer's IP is already whitelisted. If not, it adds a rule to allow traffic from that IP on the remote system’s `INPUT` chain.

### **Detailed Steps**

1. **Public IP Detection on Developer Machine**:
    - The Python script (`who-am-i.py`) detects the public IP of the developer's machine.

2. **Bash Script on Developer Machine**:
    - The developer runs a Bash script (`set_Developer_IP.sh`) that:
        - Detects the public IP.
        - Exports the `Developer_IP` environment variable.
        - Initiates an SSH connection to the remote server.

3. **SSH with `SendEnv` Option**:
    - The developer’s machine connects to the remote server using SSH and passes the `Developer_IP` as an environment variable.
    
    ```bash
    ssh -o SendEnv=Developer_IP developer@remote.server.com 'bash /path/to/update_iptables.sh'
    ```

4. **Remote Server iptables Update**:
    - The remote server runs the `update_iptables.sh` script. This script:
        - Reads the `Developer_IP` environment variable.
        - Checks if the IP address is already whitelisted in the `iptables` `INPUT` chain.
        - If not present, it adds a rule at the top of the chain to allow traffic from the `Developer_IP`.

---

## **Technology Stack**

1. **Local Machine**:
    - **Python**: Used to detect the developer’s public IP.
    - **Bash**: Used to run the main automation script and export environment variables.
    - **SSH**: Used to securely connect to the remote server and execute the remote script.
    
2. **Remote Server**:
    - **Bash**: A script that updates the `iptables` firewall with the developer’s IP address.
    - **iptables**: The firewall that controls access to the server. The developer’s IP is dynamically added to the `INPUT` chain.

---

## **Scripts Overview**

### 1. **Local Script (`set_Developer_IP.sh`)**

```bash
#!/bin/bash

# Path to the public IP detection script
script_path="$HOME/natdem/fail2ban/who-am-i.py"

# Check if the script is executable
if [ -x "$script_path" ]; then
    script_output=$("$script_path")
else
    echo "Script is not executable: $script_path"
    exit 1
fi

# Extract the IP address from the output
ip_address=$(echo "$script_output" | grep -oP '\d+\.\d+\.\d+\.\d+')

# If IP address is detected, export it and initiate SSH
if [ -n "$ip_address" ]; then
    export Developer_IP="$ip_address"
    echo "Developer_IP has been set to $Developer_IP"
    
    # SSH into the remote server, passing the IP and running the update script
    ssh -o SendEnv=Developer_IP developer@remote.server.com 'bash /path/to/update_iptables.sh'
else
    echo "No IP address found in the script output."
    exit 1
fi
```

### 2. **Remote Script (`update_iptables.sh`)**

```bash
#!/bin/bash

# Check if Developer_IP is set
if [ -z "$Developer_IP" ]; then
    echo "Developer_IP is not set. Exiting."
    exit 1
fi

# Check if the IP is already in iptables
if sudo iptables -C INPUT -s "$Developer_IP" -j ACCEPT 2>/dev/null; then
    echo "IP $Developer_IP is already whitelisted."
else
    # Add the Developer_IP to the INPUT chain
    sudo iptables -I INPUT 1 -s "$Developer_IP" -j ACCEPT
    echo "IP $Developer_IP has been added to the iptables."
fi
```

---

## **Security Considerations**

- **SSH Authentication**: Ensure the SSH connection uses secure methods, such as public key authentication.
- **Environment Variable Control**: Limit which environment variables can be passed using `AcceptEnv` in `/etc/ssh/sshd_config` on the remote server:
  
    ```bash
    AcceptEnv Developer_IP
    ```

- **Firewall Security**: Ensure that only trusted IP addresses are added to the `iptables` rules and that invalid or malicious IP addresses are not accepted.

---

## **Conclusion**
This solution dynamically updates `iptables` on the remote server with the developer's current IP address. It ensures that developers can always access the server without being locked out, even when their IP address changes frequently.
