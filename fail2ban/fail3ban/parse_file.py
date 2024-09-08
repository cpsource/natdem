#!/usr/bin/python3
def parse_file(filename):
    sections = {}
    current_section = None

    with open(filename, 'r') as file:
        for line in file:
            # Strip whitespace from the line
            line = line.strip()

            # Skip empty lines
            if not line:
                continue

            # Check if the line starts with a section in square brackets
            if line.startswith('[') and line.endswith(']'):
                # Set the current section
                current_section = line[1:-1]  # Extract section name
                sections[current_section] = []  # Initialize section with an empty list
            elif current_section:
                # Add data to the current section
                sections[current_section].append(line)

    return sections

# Example usage
if __name__ == "__main__":
    parsed_data = parse_file('example_file.txt')
    for section, data in parsed_data.items():
        print(f"Section: {section}")
        for line in data:
            print(f"  {line}")

