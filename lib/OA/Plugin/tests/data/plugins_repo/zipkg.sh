#!/bin/sh

  arg="$1"

  case $arg in
  --help)
    echo \
    "Usage: zipkg [FOLDER]"
    exit 0
    ;;

  esac

  arg="testPluginPackage_v1"

  echo "$arg"

  rm "$arg".zip

  cd "$arg"

  zip -r ../"$arg" . -x \*.svn/*

  cd ..

  arg="testPluginPackage_v2"

  echo "$arg"

  rm "$arg".zip

  cd "$arg"

  zip -r ../"$arg" . -x \*.svn/*

  cd ..

  arg="testPluginPackage_v3"

  echo "$arg"

  rm "$arg".zip

  cd "$arg"

  zip -r ../"$arg" . -x \*.svn/*

  cd ..


  exit 0
