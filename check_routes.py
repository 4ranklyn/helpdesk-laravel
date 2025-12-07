import subprocess
import json
import sys

try:
    # Run php artisan route:list --json
    result = subprocess.run(['php', 'artisan', 'route:list', '--json'], capture_output=True, text=True, check=True)
    routes = json.loads(result.stdout)

    names = {}
    duplicates = []

    for route in routes:
        name = route.get('name')
        if name:
            if name in names:
                duplicates.append({'name': name, 'uri': route.get('uri'), 'existing_uri': names[name]})
            else:
                names[name] = route.get('uri')

    if duplicates:
        print("Found duplicate route names:")
        for dup in duplicates:
            print(f"Name: {dup['name']}, URI: {dup['uri']}, Existing URI: {dup['existing_uri']}")
    else:
        print("No duplicate route names found.")

except subprocess.CalledProcessError as e:
    print(f"Error running route:list: {e}")
    print(e.stderr)
except json.JSONDecodeError as e:
    print(f"Error decoding JSON: {e}")
    print(result.stdout[:500]) # Print start of output
