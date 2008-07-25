#!/bin/sh

  arg="$1"

  case $arg in
  --help)
    echo \
    "Usage: zipkg [FOLDER]"
    exit 0
    ;;

  esac

  echo "$arg"

  rm testPluginPackage.zip

  cp "$arg".zip testPluginPackage.zip

  exit 0
