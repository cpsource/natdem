import mysql.connector
from mysql.connector import Error

def connect_to_database(host, user, password, database):
    try:
        # Establish the connection to the remote MySQL/MariaDB database
        connection = mysql.connector.connect(
            host=host,
            user=user,
            password=password,
            database=database
        )

        if connection.is_connected():
            print("Successfully connected to the database")

            # Get server info
            db_info = connection.get_server_info()
            print("Connected to MySQL Server version ", db_info)

            # Create a cursor and execute a simple query
            cursor = connection.cursor()
            cursor.execute("SELECT DATABASE();")
            record = cursor.fetchone()
            print("You're connected to database: ", record)

    except Error as e:
        print(f"Error: {e}")
    finally:
        if connection.is_connected():
            cursor.close()
            connection.close()
            print("MySQL connection is closed")

if __name__ == "__main__":
    # Replace these with your actual connection details
    host = "127.0.0.1"     # e.g., "192.168.1.100"
    user = "your_username"        # e.g., "admin"
    password = "your_password"    # e.g., "password123"
    database = "your_database"    # e.g., "my_database"

    connect_to_database(host, user, password, database)

