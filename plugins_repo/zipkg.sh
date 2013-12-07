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

  rm -f "$arg".zip

  cd "$arg"

  zip -D -r ../"$arg".zip . -x \*.git\* \*.svn/* \*tests/* \*extensions/* \*/packages/* \*.bak \*.template.xml \*default.properties

  cd ..

  exit 0
