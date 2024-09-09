class Config:
    def __init__(self, config_file='config.ctl'):
        self.config_data = {}
        self.load_config(config_file)

    def get_config_data(self):
        return self.config_data
    
    def load_config(self, config_file):
        """Read the config.ctl file and store variable-value pairs."""
        try:
            with open(config_file, 'r') as file:
                for line in file:
                    # Strip whitespace and skip comments and empty lines
                    line = line.strip()
                    if not line or line.startswith('#'):
                        continue
                    
                    # Split the line into variable and value
                    if '=' in line:
                        variable, value = map(str.strip, line.split('=', 1))
                        self.config_data[variable] = value
        except FileNotFoundError:
            print(f"Error: {config_file} not found.")
        except Exception as e:
            print(f"An error occurred while reading {config_file}: {e}")

        # return this dictionary
        return self.config_data
    
    def get_value(self, variable_name):
        """Retrieve the value of the specified variable."""
        return self.config_data.get(variable_name, None)

def main():
    # Create a Config instance and load the config.ctl file
    config = Config('config.ctl')

    # Test getting values
    test_variable = 'debug'
    result = config.get_value(test_variable)

    if result is not None:
        print(f"The value for '{test_variable}' is: {result}")
    else:
        print(f"'{test_variable}' not found in config.ctl")


if __name__ == "__main__":
    main()

