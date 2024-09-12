import openai
import os
import json
import argparse
import sys

class ChatWithOpenAI:
    def __init__(self, model="gpt-4o-2024-08-06"):
        """
        Initialize the chat class, retrieving the API key from the environment and setting the model.
        """
        self.api_key = os.getenv("OPENAI_API_DOC_PROJECT_KEY")
        if not self.api_key:
            raise ValueError("OpenAI API_DOC_PROJECT_KEY key not found in environment variables.")
        openai.api_key = self.api_key
        self.model = model
        self.messages = []  # Store the conversation history

    def set_system(self, content):
        """
        Set the system message to define the assistant's behavior.
        """
        self.messages.append({"role": "system", "content": content})

    def user_message(self, content):
        """
        Add the user's message to the conversation.
        """
        self.messages.append({"role": "user", "content": content})

    def get_response(self):
        """
        Get the assistant's response from OpenAI, while maintaining context.
        """
        try:
            response = openai.chat.completions.create(
                model=self.model,
                messages=self.messages
            )
            assistant_message = response.choices[0].message.content
            #assistant_message = response['choices'][0].message.content
            self.messages.append({"role": "assistant", "content": assistant_message})
            return assistant_message
        except Exception as e:
            return f"Error: {str(e)}"

    def send_file(self, file_path):
        """
        Reads the contents of a file and sends it as a user message.
        Only works for text files; you can modify it for other types as needed.
        """
        if not os.path.exists(file_path):
            return f"Error: File {file_path} does not exist."

        try:
            with open(file_path, 'r') as file:
                file_contents = file.read()

            # Add the file contents as a user message
            self.user_message(f"Here is the content of the file '{file_path}':\n\n{file_contents}")
            return f"File '{file_path}' sent successfully."
        except Exception as e:
            return f"Error reading file: {str(e)}"
        
    def reset_conversation(self):
        """
        Clear the chat history.
        """
        self.messages = []

# Example usage
if __name__ == "__main__":
    # Set the OpenAI API key as an environment variable before running the script.
    # Example: export OPENAI_API_KEY="your-api-key-here"

    # Set up the argument parser
    parser = argparse.ArgumentParser(description='Chat with OpenAI and send a file.')
    parser.add_argument('file_path', help='The path of the file to send to OpenAI.')

    # Parse the arguments
    args = parser.parse_args()

    # Check if the file_path is provided
    if not args.file_path:
        print("Error: No file provided.")
        sys.exit(1)

    # Create a chat instance
    chat = ChatWithOpenAI()

    # Set the assistant's behavior
    chat.set_system("Help document the attached python3 code.")

    # load a file into assistant
    chat.send_file("./monitorJournalctl.py")
    
    # User sends a message
    chat.user_message("Please document the attached python3 file in markdown format.")

    # Get the assistant's response
    print("Assistant:", chat.get_response())

