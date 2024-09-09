import sqlite3
from datetime import datetime, timedelta
import ipaddress

import sqlite3
from datetime import datetime, timedelta
import ipaddress

class SQLiteDB:
    def __init__(self):
        self.db_name = None
        self.connection = None
        self.cursor = None

    def initialize(self, db_name):
        """Initialize the SQLite database, creating it if it doesn't exist."""
        self.db_name = db_name
        self.connection = sqlite3.connect(self.db_name)
        self.cursor = self.connection.cursor()

        # Create the table if it doesn't exist
        self.create_ban_table()

    def create_ban_table(self):
        """Create the ban_table if it doesn't already exist."""
        create_table_query = '''
        CREATE TABLE IF NOT EXISTS ban_table (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            ip_address CHAR(39),
            jail CHAR(100),
            usage_count INTEGER,
            ban_expire_time DATETIME,
            UNIQUE(ip_address, jail)
        )
        '''
        self.cursor.execute(create_table_query)
        self.connection.commit()

    def add_or_update_ban(self, ip_addr, jail_name, minutes_until_ban_end):
        """Add a new ban or update an existing ban based on ip_address and jail."""
        # Parse and expand the IP address (IPv6 addresses to full form)
        try:
            ip_obj = ipaddress.ip_address(ip_addr)
            ip_addr = ip_obj.exploded  # Use the long form of the IP address
        except ValueError:
            print(f"Invalid IP address: {ip_addr}")
            return

        # Calculate new ban expiration time
        ban_expire_time = datetime.now() + timedelta(minutes=minutes_until_ban_end)

        # Look up the existing record by ip_address and jail_name
        select_query = '''
        SELECT id, usage_count FROM ban_table WHERE ip_address = ? AND jail = ?
        '''
        self.cursor.execute(select_query, (ip_addr, jail_name))
        record = self.cursor.fetchone()

        if record:
            # If the record exists, update usage_count and ban_expire_time
            update_query = '''
            UPDATE ban_table 
            SET usage_count = usage_count + 1, ban_expire_time = ? 
            WHERE ip_address = ? AND jail = ?
            '''
            self.cursor.execute(update_query, (ban_expire_time, ip_addr, jail_name))
            print(f"Updated ban for {ip_addr} in jail {jail_name}.")
        else:
            # If the record does not exist, insert a new record
            insert_query = '''
            INSERT INTO ban_table (ip_address, jail, usage_count, ban_expire_time) 
            VALUES (?, ?, ?, ?)
            '''
            self.cursor.execute(insert_query, (ip_addr, jail_name, 1, ban_expire_time))
            print(f"Added new ban for {ip_addr} in jail {jail_name}.")

        # Commit the changes
        self.connection.commit()

    def get_expired_records(self):
        """Return a list of expired records in the form [ip_addr, True-if-ipv6, else False, jail]."""
        expired_records = []

        # Get the current time
        current_time = datetime.now()

        # Query for expired records (ban_expire_time < current_time)
        query = '''
        SELECT ip_address, jail, ban_expire_time FROM ban_table WHERE ban_expire_time < ?
        '''
        self.cursor.execute(query, (current_time,))
        records = self.cursor.fetchall()

        # Process each record to check if the IP is IPv6 and format the output
        for record in records:
            ip_addr, jail, ban_expire_time = record
            # Determine if the IP address is IPv6 using ipaddress module
            try:
                ip_obj = ipaddress.ip_address(ip_addr)
                is_ipv6 = isinstance(ip_obj, ipaddress.IPv6Address)

                # If it's IPv6, shrink it to its smallest form (compressed)
                if is_ipv6:
                    ip_addr = ip_obj.compressed
            except ValueError:
                # Handle any invalid IP address (if applicable)
                is_ipv6 = False

            # Add the record in the form [ip_addr, is_ipv6, jail]
            expired_records.append([ip_addr, is_ipv6, jail])

        return expired_records

    def show_bans(self, ip_addr=None, jail_name=None):
        """Print a list of records in a human-readable format for the given ip_addr and jail_name."""
        # Build the base query
        query = "SELECT id, ip_address, jail, usage_count, ban_expire_time FROM ban_table WHERE 1=1"
        params = []

        # Add filtering by ip_addr if provided
        if ip_addr:
            query += " AND ip_address = ?"
            params.append(ip_addr)

        # Add filtering by jail_name if provided
        if jail_name:
            query += " AND jail = ?"
            params.append(jail_name)

        # Execute the query
        self.cursor.execute(query, tuple(params))
        records = self.cursor.fetchall()

        # Check if records were found
        if records:
            print(f"Found {len(records)} record(s):")
            for record in records:
                ip_addr, jail = record[1], record[2]
                try:
                    ip_obj = ipaddress.ip_address(ip_addr)
                    is_ipv6 = isinstance(ip_obj, ipaddress.IPv6Address)
                    if is_ipv6:
                        ip_addr = ip_obj.compressed  # Shrink IPv6 address to its compressed form
                except ValueError:
                    is_ipv6 = False
                print(f"ID: {record[0]}, IP: {ip_addr}, Jail: {jail}, Usage Count: {record[3]}, Ban Expire Time: {record[4]}")
        else:
            print("No matching records found.")

    def remove_record(self, ip_addr, jail_name):
        """Remove a record from the ban_table based on ip_address and jail_name."""
        delete_query = '''
        DELETE FROM ban_table WHERE ip_address = ? AND jail = ?
        '''
        self.cursor.execute(delete_query, (ip_addr, jail_name))
        self.connection.commit()
        print(f"Record for IP {ip_addr} in jail {jail_name} has been removed.")

    def show_database(self):
        """Print all records in the database in a human-readable format, and show if the ban has expired."""
        # Get the current time
        current_time = datetime.now()

        # Query to select all records from the ban_table
        query = "SELECT id, ip_address, jail, usage_count, ban_expire_time FROM ban_table"
        
        # Execute the query
        self.cursor.execute(query)
        records = self.cursor.fetchall()

        # Check if records were found
        if records:
            print(f"Found {len(records)} record(s):")
            for record in records:
                id, ip_addr, jail, usage_count, ban_expire_time = record

                # Determine if the IP address is IPv6 and compress it
                try:
                    ip_obj = ipaddress.ip_address(ip_addr)
                    is_ipv6 = isinstance(ip_obj, ipaddress.IPv6Address)
                    if is_ipv6:
                        ip_addr = ip_obj.compressed  # Shrink IPv6 address to its compressed form
                except ValueError:
                    is_ipv6 = False

                # Check if the ban has expired
                if current_time > datetime.strptime(ban_expire_time, '%Y-%m-%d %H:%M:%S.%f'):
                    expired_status = "Expired"
                else:
                    expired_status = "Active"

                # Print the record with ban status
                print(f"ID: {id}, IP: {ip_addr}, Jail: {jail}, Usage Count: {usage_count}, "
                      f"Ban Expire Time: {ban_expire_time} ({expired_status})")
        else:
            print("No records found in the database.")

    def close(self):
        """Close the database connection."""
        if self.connection:
            self.connection.close()

            
# Example main to use the new get_expired_records method
def main():
    db = SQLiteDB()
    db.initialize('bans.db')

    # Example usage of add_or_update_ban method
    ip_addr = '2001:db8::1'  # Example shortened IPv6 address
    jail_name = 'ssh'
    minutes_until_ban_end = 1  # Set short ban for testing
    # First call to add_or_update_ban (inserts a new record)
    db.add_or_update_ban(ip_addr, jail_name, minutes_until_ban_end)

    # Example usage of add_or_update_ban method
    ip_addr = '192.168.8.0'  # Example IPv4 address
    jail_name = 'ssh'
    minutes_until_ban_end = 1  # Set short ban for testing
    # First call to add_or_update_ban (inserts a new record)
    db.add_or_update_ban(ip_addr, jail_name, minutes_until_ban_end)

    # and show
    db.show_database()
    
    # Wait for the ban to expire (for testing purposes)
    print("Waiting for the bans to expire...")
    import time
    time.sleep(70)  # Wait for over a minute

    # Get and print expired records
    expired_records = db.get_expired_records()
    if expired_records:
        print("Expired records:")
        for record in expired_records:
            print(record)
    else:
        print("No expired records.")

    # and lastly
    db.show_database()
        
    db.close()

if __name__ == "__main__":
    main()    
