import sqlite3
import os

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
            ip_address CHAR(40),
            jail CHAR(100),
            usage_count INTEGER,
            ban_expire_time TIME,
            UNIQUE(ip_address)
        )
        '''
        self.cursor.execute(create_table_query)
        self.connection.commit()

    def __del__(self):
        """Destructor to ensure the database connection is closed."""
        if self.connection:
            print("Closing the database connection")
            self.connection.close()

# Example of using the class
def main():
    db = SQLiteDB()
    
    # Initialize the database with the specified name
    db.initialize('bans.db')
    
    # Close the connection when done
    db = None

if __name__ == "__main__":
    main()
