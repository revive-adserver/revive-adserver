#!/bin/sh

# A shell script to generate the OpenX documentation.
# Requires phpDocumentor be installed.
#
# Copyright (c) 2003-2008 OpenX Limited
# For contact details, see: http://www.openx.org/
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

###################################
# Start user configurable section #
###################################

# Location of the phpdocumentor
PATH_PHPDOC="/usr/local/php4/bin/phpdoc"

# Source code location
PATH_SRC="../"

# Output location for documentation
PATH_DOCS="../docs/developer/api"

# Output format to use
OUTPUT_FORMAT="HTML"

# Output style
CONVERTER="frames"
TEMPLATE="DOM/earthli"

###################################
# End user configurable section   #
###################################

# "Fixed" values
TITLE="OpenX API"
PACKAGES="Max"
PRIVATE="on"

# Delete, create output directory
rm -rf $PATH_DOCS
mkdir $PATH_DOCS

# Make documentation
$PATH_PHPDOC \
  -d $PATH_SRC/lib/max,$PATH_SRC/plugins,$PATH_SRC/scripts,$PATH_SRC/tests,$PATH_SRC/tutorials,$PATH_SRC/www \
  -f $PATH_SRC/constants.php,$PATH_SRC/index.php,$PATH_SRC/init-delivery-parse.php,$PATH_SRC/init-delivery.php,$PATH_SRC/init-parse.php,$PATH_SRC/init.php,$PATH_SRC/lib/Max.php \
  -t $PATH_DOCS \
  -ti "$TITLE" \
  -dn $PACKAGES \
  -o $OUTPUT_FORMAT:$CONVERTER:$TEMPLATE \
  -pp $PRIVATE
