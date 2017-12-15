#!/bin/bash
##############################################################################
# $Id$
# cache_clear.sh crée avec cs par fab le '2017-12-15 21:31:55'
VERSION=0.0.1
# Objectif :
#
# Author: Fabrice Mendes
# Last Revision :
# - $Revision$
# - $Author$
# - $Date$
#
######################################################(FAb)###################

ME=$0
cmd=$1

user=$(id -u)
my_group=$(id -g)
apache_g=$(getent passwd  www-data |awk 'BEGIN{FS=":"} {print $4}')
apache_u=$(getent passwd  www-data |awk 'BEGIN{FS=":"} {print $3}')
owner_id=$(stat -c %g $ME)
owner_name=$(stat -c %U $ME)

dirs="var/cache web/bundles"

function call_cache_script()
{
    wget -q -O - $url
    rc=$?
    return $rc    
}

function fix_perms()
{
    chown -R $owner_name:www-data var/cache/
    chown -R www-data:www-data web/bundles/
    chmod -R ug+rw,o-rw $dirs
}

if [ $my_group != $apache_g ]; then
    echo "*** You($my_group) SHOULD be in apache group ($apache_g)***" 2>&1
    echo "try: newgrp www-data" 2>&1
    #exit 1
fi

f_url='cache_clear.url.txt'
if [ ! -f $f_url ]; then
    echo "Missing file with url '$f_url'" 2>&1
    exit 1
fi
url="$(cat $f_url)"

if [ "x$url" = "x" ]; then
    echo "missing url" 2>&1
    exit 3
fi


bad_files=$( find var/cache \( \! -user $owner_name -o \! -group $apache_g \) )
bad_files2=$( find web/bundles \( \! -user $apache_u -o \! -group $apache_g \) )
bad_files="${bad_files}${bad_files2}"

if [ "x$cmd" = "xforce" ]; then
    bad_files="force"
fi
echo $bad_files

if [ "x$bad_files" != "x" ]; then
    echo "Need to fix perms"
    if [ $user -ne 0 ]; then
        echo "sudo myself! ($user -ne 0)"
        sudo $ME $cmd
        exit 0
    fi
    echo "fixing var to ${owner_name}:www-data as $user"
    #set -x
    fix_perms
    echo "Perms fixed!"
    call_cache_script
    fix_perms
    set +x
    exit 0
fi

call_cache_script
exit $rc
