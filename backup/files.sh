#!/bin/bash

local_folder= # Set the local folder path
remote_folder= # Set the Box remote folder ID

remote_files=()

for file in $(box folders:items --json --fields 'name' $remote_folder | jq --raw-output '.[].name'); do
    remote_files+=("$file")
done

for file in ${local_folder}/*.svg; do
    local_file=$(basename $file)
    already_exists=false

    for remote_file in "${remote_files[@]}"; do
        if [ "$remote_file" == "$local_file" ]; then
            already_exists=true
            break
        fi
    done

    if [ "$already_exists" = true ]; then
        echo "File ${local_file} already exists."
    else
        echo "Uploading file ${local_file}..."
        box files:upload --parent-id $remote_folder --quiet $file
    fi
done
