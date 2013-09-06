#!/bin/bash

export PHP_COMMAND=`which php`
export PHING_HOME=../../lib/pear/phing
export PHP_CLASSPATH=${PHING_HOME}/classes
export PATH=${PATH}:${PHING_HOME}/bin

phing