<?php
/*******************************************************************************
	phpTimer: A simple script to time script execution
	Copyright (C) 2001 Roger Raymond ~ epsilon7@users.sourceforge.net

	This library is free software; you can redistribute it and/or
    modify it under the terms of the GNU Lesser General Public
    License as published by the Free Software Foundation; either
    version 2.1 of the License, or (at your option) any later version.

    This library is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
    Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public
    License along with this library; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*******************************************************************************/

if(!defined('_PHP_TIMER_INCLUDED')) define('_PHP_TIMER_INCLUDED',1);
class phpTimer {

function phpTimer () 
{	$this->_version = '0.1';
    $this->_enabled = true;
}

function start ($name = 'default') 
{	if($this->_enabled) 
	{	$this->_timing_start_times[$name] = explode(' ', microtime());
    }
}

function stop ($name = 'default') 
{	if($this->_enabled) 
	{	$this->_timing_stop_times[$name] = explode(' ', microtime());
    }
}

function get_current ($name = 'default') 
{	if($this->_enabled) 
	{	if (!isset($this->_timing_start_times[$name])) 
		{	return 0;
        }
        if (!isset($this->_timing_stop_times[$name])) 
		{	$stop_time = explode(' ', microtime());
        }
        else 
		{	$stop_time = $this->_timing_stop_times[$name];
        }
        // do the big numbers first so the small ones aren't lost
        $current = $stop_time[1] - $this->_timing_start_times[$name][1];
        $current += $stop_time[0] - $this->_timing_start_times[$name][0];
        return sprintf("%.10f",$current);
    }
    else 
	{	return 0;
    }
}

}