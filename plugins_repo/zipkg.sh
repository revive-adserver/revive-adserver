#!/bin/sh

  arg="$1"

  if [ -z "$arg" ]; then
    arg="--help"
  fi

  case $arg in
  --help)
    echo \
    "Usage: zipkg [FOLDER]"
    exit 0
    ;;
  esac

  while [ -n "$2" ]; do
  case $2 in
      -b) 
        bump=1
        shift 1
        
        if [ -n "$2" ]; then
            PLUGIN_GROUP_NAME="$2"
            shift 1
        fi
        ;;
      *)  break;;
  esac
  done

  if [ -n "$bump" ]; then
    ./version_bump.sh "$arg" "$PLUGIN_GROUP_NAME"
  fi

  rm -f "$arg".zip

  cd "$arg"

  zip -D -r ../"$arg".zip . -x \*.git\* \*.svn/* \*tests/* \*extensions/* \*/packages/* \*.bak \*.template.xml \*default.properties -x "*.DS_Store" -x "__MACOSX" -x "__MACOSX/*" -x "*/._*"

  cd ..

  exit 0
