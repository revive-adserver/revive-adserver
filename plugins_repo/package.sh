#!/bin/sh

  arg="$1"

  if [ -z "$arg" ]; then
    arg="--help"
  fi

  case $arg in
  --help)
    echo \
    "Usage: package [FOLDER] [ -r -b ]

     -r Release (copy file to release folder) When releasing a new plugin you will need to edit releases/release.xml
     -b Bundle (copy file to etc/plugins folder) When bundling a new plugin you will need to edit etc/default_plugins.php"

    exit 0
    ;;
  esac

# Parse parameter list
while [ -n "$2" ]; do
case $2 in
    -r) release=1;shift 1;;
    -b) bundle=1;shift 1;;
    -*) echo "Invalid option: $2";exit 1;;
    *)  break;;
esac
done

rm "$arg".zip
sh ./zipkg.sh "$arg"

if [ -z "$bundle" ]; then
    cp "$arg".zip release/
fi

if [ -z "$release" ]; then
    cp "$arg".zip ../etc/plugins/
fi


exit 0


