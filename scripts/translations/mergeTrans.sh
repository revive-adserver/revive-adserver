#!/bin/sh
# mergeTrans <openx root directory> <language> <language> <language> ....
# sh scripts/translations/mergeTrans.sh /path/to/openx pt_BR zh_CN fr de it ja pl ro ru sl es

PHP='/usr/bin/php'
WGET='/usr/bin/wget'
POOTLE_SERVER='http://translate.openx.org'
POOTLE_PROJECT='oxp28'

if [ "$#" -eq 0 ]; then
    echo
    echo "Usage: $(basename $0) /path/to/openx pt_BR zh_CN fr de it ja pl ro ru sl es"
    echo
    exit 1
fi

count=1
until [ -z "$*" ]
do
    if [ $count = 1 ]
    then
	dir=$1
    else
	$WGET ${POOTLE_SERVER}/$1/${POOTLE_PROJECT}/openx.csv -O $dir/scripts/translations/csv/openx_$1.csv;
	$PHP $dir/scripts/translations/translation.php merge $dir/scripts/translations/csv/openx_$1.csv $dir/lib/max/language/$1 $1

	#$WGET ${POOTLE_SERVER}/$1/${POOTLE_PROJECT}/plugins.csv -O $dir/scripts/translations/csv/plugins_$1.csv
	#$PHP $dir/scripts/translations/translation.php mergePlugin $dir/scripts/translations/csv/plugins_$1.csv $dir/plugins/ $1
    fi
    shift
    count=`expr $count + 1`
done

