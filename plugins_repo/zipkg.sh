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

  #echo "$arg"

  rm "$arg".zip

  cd "$arg"

  zip -D -r ../"$arg".zip . -x \*.svn/* \*tests/* \*extensions/* \*/packages/* \*.bak \*.template.xml \*default.properties

  cd ..

  exit 0
