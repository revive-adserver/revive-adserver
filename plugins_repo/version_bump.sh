#!/bin/sh

PLUGIN_NAME="$1"
PLUGIN_GROUP_NAME="$2"

if [ -z "$PLUGIN_NAME" ]; then
    echo "Error: Please provide the plugin name (e.g., openXInvocationTags)."
    exit 1
fi

if [ -z "$PLUGIN_GROUP_NAME" ]; then
    echo "Error: Please provide the plugin group name (e.g., oxInvocationTags)."
    exit 1
fi

CORE_PLUGIN_XML="${PLUGIN_NAME}/plugins/etc/${PLUGIN_NAME}.xml"
GROUP_PLUGIN_XML="${PLUGIN_NAME}/plugins/etc/${PLUGIN_GROUP_NAME}/${PLUGIN_GROUP_NAME}.xml"

bump_version() {
    local FILE_PATH="$1"
    
    if [ ! -f "$FILE_PATH" ]; then
        echo "Warning: Plugin XML file not found at $FILE_PATH"
        return 1
    fi

    CURRENT_VERSION_TAG=$(grep -oE "<version>[0-9]+\.[0-9]+\.([0-9]+)</version>" "$FILE_PATH" | head -n 1)
    
    if [ -z "$CURRENT_VERSION_TAG" ]; then
        echo "Error: Could not find version tag in $FILE_PATH"
        exit 1
    fi

    PATCH_VERSION=$(echo "$CURRENT_VERSION_TAG" | sed -E 's/.*\.([0-9]+)<\/version>/\1/')
    NEW_PATCH=$((PATCH_VERSION + 1))
    NEW_VERSION_TAG=$(echo "$CURRENT_VERSION_TAG" | sed -E "s/([0-9]+)<\/version>/$NEW_PATCH<\/version>/")

    sed -i '' -E "s|$CURRENT_VERSION_TAG|$NEW_VERSION_TAG|" "$FILE_PATH"
    echo "Bumped version in $FILE_PATH to 1.8.$NEW_PATCH"
}

bump_version "$CORE_PLUGIN_XML"
bump_version "$GROUP_PLUGIN_XML"