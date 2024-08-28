#!/usr/bin/env python3

import subprocess

print("Content-Type: text/html\n")
print("<html><head><title>Execute Perl Script</title></head><body>")
print("<h1>Output of printenv.pl</h1>")

try:
    # Execute the Perl script and capture the output
    result = subprocess.run(['/usr/bin/perl', 'cgi-bin/printenv.pl'], capture_output=True, text=True)

    if result.returncode == 0:
        # Successfully executed, display the output
        print("<pre>{}</pre>".format(result.stdout))
    else:
        # There was an error during execution
        print("<p>Error executing script:</p>")
        print("<pre>{}</pre>".format(result.stderr))

except Exception as e:
    print("<p>Failed to execute script:</p>")
    print("<pre>{}</pre>".format(e))

print("</body></html>")

