#!/bin/bash

# Get the directory where the script is located
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"

# Change to the script directory
cd "$SCRIPT_DIR"

# Find and delete all Zone.Identifier files from the script's location
find "$SCRIPT_DIR" -name "*.Zone.Identifier" -type f -delete

echo "All Zone.Identifier files have been deleted from $SCRIPT_DIR and its subdirectories."
