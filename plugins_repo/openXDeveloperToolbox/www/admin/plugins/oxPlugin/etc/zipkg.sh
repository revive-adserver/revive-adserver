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

  zip -r ../"$arg".zip . -x \*.svn/* \*/tests/*

  cd ..

  exit 0
