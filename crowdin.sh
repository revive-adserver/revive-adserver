#!/bin/sh

if [ -z "$1" ]; then
	echo "Usage: $0 <crowdin arguments>"
	exit 1
fi

sed -i $'s/{\$\([^}]*\)}/{{\\1}}/g' lib/max/language/*/*.lang.php

crowdin-cli $*

sed -i $'s/{{\([^}]*\)}}/{$\\1}/g' lib/max/language/*/*.lang.php

# Remove empty translation strings from .lang.php files
sed -i '/^$.*= "";/d' lib/max/language/*/*.lang.php
sed -i "/^$.*= '';/d" lib/max/language/*/*.lang.php

# Remove empty translation files
for lang in `find lib/max/language -name '*.lang.php' `; do
	n=`grep -c '^\\$.*=' $lang`
	if [ $n -eq 0 ]; then
		rm -f $lang
	fi
done

# Compile plugin .mo files
for po in `find plugins_repo -name '*.po' `; do
	n=`grep msgstr $po | grep -v 'msgstr ""' | wc -l`
	if [ $n -eq 0 ]; then
		rm -f $po
	else
		mo=`echo "$po" | sed $'s/_lang.po/_lang/g' | sed $'s/po$/mo/g'`
		msgfmt $po -o $mo
	fi
done
