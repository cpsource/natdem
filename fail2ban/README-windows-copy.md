
# Windows to Ubuntu File Copy Scripts

These scripts are designed to facilitate file transfer between a Windows 11 host and an Ubuntu virtual machine. The Windows Downloads folder is used as a shared point for transferring data between the two systems, and these scripts automate the process.

## Prerequisites
- **Windows 11** running as the host OS.
- **Ubuntu** running as a virtual machine.
- The **Downloads** folder on Windows is accessible from Ubuntu (typically mounted at `/mnt/c/Users/pagec/Downloads/`).

## Scripts Overview

### 1. `cpup.sh`
- **Description**: This script copies a file from the Windows Downloads folder to the current directory in the Ubuntu virtual machine.
- **Usage**: 
  ```bash
  ./cpup.sh <filename>
  ```
- **Checks**:
  - If `<filename>` is not provided, it will report an error.
  - If the target file already exists in the current directory, the script will prompt to overwrite it, with the default option being `[Yn]`.
  
### 2. `cpdn.sh`
- **Description**: This script copies a file from the current directory in the Ubuntu virtual machine to the Windows Downloads folder.
- **Usage**: 
  ```bash
  ./cpdn.sh <filename>
  ```
- **Checks**:
  - If `<filename>` is not provided, it will report an error.
  - If the target file already exists in the Windows Downloads folder, the script will prompt to overwrite it, with the default option being `[Yn]`.

### 3. `lsdn.sh`
- **Description**: This script lists the 10 most recently modified files in the Windows Downloads folder.
- **Usage**:
  ```bash
  ./lsdn.sh
  ```
- **Output**: It lists the first 10 files sorted by modification time.

## Example Usage

1. To copy a file from the Windows Downloads folder to Ubuntu:
   ```bash
   ./cpup.sh example.txt
   ```
   If `example.txt` already exists in the current directory, you'll be prompted to overwrite it.

2. To copy a file from Ubuntu to the Windows Downloads folder:
   ```bash
   ./cpdn.sh example.txt
   ```
   If `example.txt` already exists in the Windows Downloads folder, you'll be prompted to overwrite it.

3. To list the first 10 files in the Windows Downloads folder:
   ```bash
   ./lsdn.sh
   ```

## Notes
- These scripts assume the Windows Downloads folder is mounted at `/mnt/c/Users/pagec/Downloads/`. Adjust the path if necessary.
- Ensure that you have the necessary permissions to access and modify files in the Windows Downloads folder from your Ubuntu virtual machine.

