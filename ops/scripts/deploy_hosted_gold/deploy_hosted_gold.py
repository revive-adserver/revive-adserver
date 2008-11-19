#!/bin/env python

import os, sys, re
from util import *

HOSTNAME = "test01.gold.ec2.openx.org"

def delete_unnecessary_packages():
    cmd = "yum -y remove authconfig bluez-libs cups-libs firstboot-tui \
        irda-utils NetworkManager nfs-utils nfs-utils-lib \
        rhpl rp-pppoe rsh system-config-network-tui \
        wireless-tools.i386 wireless-tools.x86_64 yp-tools ypbind"
    run_cmd(cmd)
    
def set_prompt():
    cmds = ['echo "" >> ~/.bashrc',
        'echo "# Set the full hostname in the prompt:" >> ~/.bashrc',
        'echo "export PS1=\'[\u@\H \w]\$ \'" >> ~/.bashrc',
        '. ~/.bashrc',
        ]
    for cmd in cmds:
        run_cmd(cmd)

def set_hostname(hostname=HOSTNAME):
    ip = get_ip_address()
    add_line_to_file("%s    %s" % (ip, hostname), '/etc/hosts')
    change_line_in_file('HOSTNAME=', 'HOSTNAME=' + hostname, '/etc/sysconfig/network')
    run_cmd('hostname ' + hostname)
    run_cmd('service syslog restart')

def install_denyhosts():
    run_cmd("yum -y install denyhosts")
    change_line_in_file('SMTP_FROM = ', 'SMTP_FROM = DenyHosts <denyhosts@openx.org>', '/etc/denyhosts.conf')
    change_line_in_file('#SYSLOG_REPORT = YES', 'SYSLOG_REPORT = YES', '/etc/denyhosts.conf')
    change_line_in_file('#SYNC_SERVER = http://xmlrpc.denyhosts.net:9911', 'SYNC_SERVER = http://xmlrpc.denyhosts.net:9911', '/etc/denyhosts.conf')
    add_line_to_file('#OpenX Hosts', '/var/lib/denyhosts/allowed-hosts')
    add_line_to_file('75.101.154.40', '/var/lib/denyhosts/allowed-hosts')
    add_line_to_file('84.12.130.35', '/var/lib/denyhosts/allowed-hosts')
    add_line_to_file('78.105.9.44', '/var/lib/denyhosts/allowed-hosts')
    enable_and_start_service('denyhosts')

def configure_mail():
    install_packages("postfix system-switch-mail")
    download_and_install_package(url='http://www.mikecappella.com/logwatch/release/postfix-logwatch-1.37.08.tgz', 
                            install_cmd='make install-logwatch')
    os.system('system-switch-mail')
    add_line_to_file('relayhost = relay.ny.openx.org', '/etc/postfix/main.cf')
    enable_and_start_service('postfix')

def configure_crontab_mailto():
    tmpcrontab = '/tmp/crontab.dump'
    run_cmd('crontab > %s' % tmpcrontab)
    add_line_to_file("MAILTO='systems@openx.org'", tmpcrontab)
    run_cmd('crontab %s' % tmpcrontab)
    os.unlink(tmpcrontab)

#### MAIN ####

configure_crontab_mailto()
sys.exit(1)
install_epel_repo()
delete_unnecessary_packages()
install_packages("subversion")
update_existing_packages()
set_hostname()
set_prompt()
install_denyhosts()
configure_mail()
