#!/bin/sh

  #echo "$arg"

  rm testPluginPackage.zip

  zip -r testPluginPackage . -x \*.svn/* \*.sh

  exit 0
