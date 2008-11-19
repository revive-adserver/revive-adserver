#!/bin/env python

import os, sys, re
import commands

def run_cmd(cmd, silent=0):
    (status, output) = commands.getstatusoutput(cmd)
    if not silent:
        print output
    return (status, output)

def get_ip_address(iface='eth0'):
    (status, output) = run_cmd('ifconfig ' + iface, silent=1)
    lines = output.split('\n')
    for line in lines:
        s = re.search('inet addr:(\S+)', line)
        if s:
            return s.group(1)
    return ""

def add_line_to_file(newline, filename):
    tmpfilename = filename + '.tmp'
    src = open(filename)
    dest = open(tmpfilename, 'w')
    for line in src.readlines():
        dest.write(line)
    dest.write(newline + '\n')
    src.close()
    dest.close()
    os.rename(tmpfilename, filename)

def delete_line_from_file(pattern, filename):
    tmpfilename = filename + '.tmp'
    src = open(filename)
    dest = open(tmpfilename, 'w')
    for line in src.readlines():
        if not re.search(pattern, line):
            dest.write(line)
    src.close()
    dest.close()
    os.rename(tmpfilename, filename)

def change_line_in_file(pattern, newline, filename):
    tmpfilename = filename + '.tmp'
    src = open(filename)
    dest = open(tmpfilename, 'w')
    for line in src.readlines():
        if re.search(pattern, line):
            dest.write(newline)
        else:
            dest.write(line)
    src.close()
    dest.close()
    os.rename(tmpfilename, filename)

def delete_unnecessary_packages():
    cmd = "yum -y remove authconfig bluez-libs cups-libs firstboot-tui \
        irda-utils NetworkManager nfs-utils nfs-utils-lib \
        rhpl rp-pppoe rsh system-config-network-tui \
        wireless-tools.i386 wireless-tools.x86_64 yp-tools ypbind"
    run_cmd(cmd)
    
def install_packages(packages):
    cmd = "yum -y install %s" % packages
    run_cmd(cmd)

def install_epel_repo():
    cmd = "rpm -Uvh http://download.fedora.redhat.com/pub/epel/5/x86_64/epel-release-5-2.noarch.rpm"
    run_cmd(cmd)

def update_existing_packages():
    cmd = "yum -y update"
    run_cmd(cmd)

def enable_and_start_service(service):
    run_cmd('chkconfig %s on' % service)
    run_cmd('service %s start' % service)

def get_package_name_from_url(url):
    elems = url.split('/')
    return elems[-1]

def unpack_package(pkg_name):
    if pkg_name.endswith('tar.gz') or pkg_name.endswith('tgz'):
        run_cmd('tar xvfz ' + pkg_name)
    elif pkg_name.endswith('tar.bz2'):
        run_cmd('tar xvfj ' + pkg_name)
    else:
        print 'Error unpacking %s: extension not supported' % pkg_name

def get_package_name_no_extension(pkg_name):
    extensions = ['.tar.gz', '.tgz', '.tar.bz2']
    for ext in extensions:
        index = pkg_name.find(ext)
        if index > -1:
            return pkg_name[0:index]
    return ""
    
def download_and_install_package(url, dest='/usr/local/src', \
                        install_cmd='./configure; make; make install'):
    if not os.path.isdir(dest):
        os.path.makedirs(dest)
    cwd = os.getcwd()
    os.chdir(dest)
    pkg_name = get_package_name_from_url(url)
    fullpath = os.path.join(dest, pkg_name)
    if os.path.isfile(fullpath):
        os.unlink(fullpath)
    run_cmd('wget ' + url)
    unpack_package(pkg_name)
    pkg_dir = get_package_name_no_extension(pkg_name)
    os.chdir(pkg_dir)
    run_cmd(install_cmd)
