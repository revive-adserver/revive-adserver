<?php
/*
 *  $Id: b3da56b5c4a474257b4e78542d47fdb2d9f26aa8 $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://phing.info>.
 */

require_once 'phing/Task.php';
require_once 'Ssh2MethodParam.php';

/**
 * Execute commands on a remote host using ssh.
 *
 * @author    Johan Van den Brande <johan@vandenbrande.com>
 * @version   $Id: b3da56b5c4a474257b4e78542d47fdb2d9f26aa8 $
 * @package   phing.tasks.ext
 */
class SshTask extends Task {

    private $host = "";
    private $port = 22;
    private $methods = null;
    private $username = "";
    private $password = "";
    private $command = "";
    private $pubkeyfile = '';
    private $privkeyfile = '';
    private $privkeyfilepassphrase = '';
    private $pty = '';
    private $failonerror = false;

    /**
     * The name of the property to capture (any) output of the command
     * @var string
     */
    private $property = "";
    
    /**
     * Whether to display the output of the command
     * @var boolean
     */
    private $display = true;

    public function setHost($host) 
    {
        $this->host = $host;
    }

    public function getHost() 
    {
        return $this->host;
    }

    public function setPort($port) 
    {
        $this->port = $port;
    }

    public function getPort() 
    {
        return $this->port;
    }

    public function setUsername($username) 
    {
        $this->username = $username;
    }

    public function getUsername() 
    {
        return $this->username;
    }

    public function setPassword($password) 
    {
        $this->password = $password;
    }

    public function getPassword() 
    {
        return $this->password;
    }

    /**
     * Sets the public key file of the user to scp
     */
    public function setPubkeyfile($pubkeyfile)
    {
        $this->pubkeyfile = $pubkeyfile;
    }

    /**
     * Returns the pubkeyfile
     */
    public function getPubkeyfile()
    {
        return $this->pubkeyfile;
    }
    
    /**
     * Sets the private key file of the user to scp
     */
    public function setPrivkeyfile($privkeyfile)
    {
        $this->privkeyfile = $privkeyfile;
    }

    /**
     * Returns the private keyfile
     */
    public function getPrivkeyfile()
    {
        return $this->privkeyfile;
    }
    
    /**
     * Sets the private key file passphrase of the user to scp
     */
    public function setPrivkeyfilepassphrase($privkeyfilepassphrase)
    {
        $this->privkeyfilepassphrase = $privkeyfilepassphrase;
    }

    /**
     * Returns the private keyfile passphrase
     */
    public function getPrivkeyfilepassphrase($privkeyfilepassphrase)
    {
        return $this->privkeyfilepassphrase;
    }
    
    public function setCommand($command) 
    {
        $this->command = $command;
    }

    public function getCommand() 
    {
        return $this->command;
    }

    public function setPty($pty)
    {
        $this->pty = $pty;
    }

    public function getPty()
    {
        return $this->pty;
    }

    /**
     * Sets the name of the property to capture (any) output of the command
     * @param string $property
     */
    public function setProperty($property)
    {
        $this->property = $property;
    }
    
    /**
     * Sets whether to display the output of the command
     * @param boolean $display
     */
    public function setDisplay($display)
    {
        $this->display = (boolean) $display;
    }

    /**
     * Sets whether to fail the task on any error
     * @param boolean $failOnError
     */
    public function setFailonerror($failonerror)
    {
        $this->failonerror = (boolean) $failonerror;
    }

    /**
     * Creates an Ssh2MethodParam object. Handles the <sshconfig /> nested tag
     * @return Ssh2MethodParam
     */
    public function createSshconfig()
    {
        $this->methods = new Ssh2MethodParam();
        return $this->methods;
    }


    public function init() 
    {
    }

    public function main() 
    {
        $p = $this->getProject();

        if (!function_exists('ssh2_connect')) { 
            throw new BuildException("To use SshTask, you need to install the PHP SSH2 extension.");
        }


        $methods = !empty($this->methods) ? $this->methods->toArray($p) : array();
        $this->connection = ssh2_connect($this->host, $this->port, $methods);
        if (!$this->connection) {
            throw new BuildException("Could not establish connection to " . $this->host . ":" . $this->port . "!");
        }

        $could_auth = null;
        if ( $this->pubkeyfile ) {
            $could_auth = ssh2_auth_pubkey_file($this->connection, $this->username, $this->pubkeyfile, $this->privkeyfile, $this->privkeyfilepassphrase);
        } else {
            $could_auth = ssh2_auth_password($this->connection, $this->username, $this->password);
        }
        if (!$could_auth) {
            throw new BuildException("Could not authenticate connection!");
        }

        if ($this->pty != '') {
            $stream = ssh2_exec($this->connection, $this->command, $this->pty);
        } else {
            $stream = ssh2_exec($this->connection, $this->command);
        }

        if (!$stream) {
            throw new BuildException("Could not execute command!");
        }
        
        $this->log("Executing command {$this->command}", Project::MSG_VERBOSE);
        
        stream_set_blocking($stream, true);
        $result = stream_get_contents($stream);

        // always load contents of error stream, to make sure not one command failed
        $stderr_stream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        stream_set_blocking($stderr_stream, true);
        $result_error = stream_get_contents($stderr_stream);
        
        if ($this->display) {
            print($result);
        }
        
        if (!empty($this->property)) {
            $this->project->setProperty($this->property, $result);
        }
        
        fclose($stream);
        if (isset($stderr_stream)) {
            fclose($stderr_stream);
        }

        if ($this->failonerror && !empty($result_error)) {
            throw new BuildException("SSH Task failed: " . $result_error);
        }
    }
}

