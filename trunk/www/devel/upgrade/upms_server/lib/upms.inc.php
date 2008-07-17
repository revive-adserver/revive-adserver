<?php

require_once(UPMS_PATH.'/lib/pear/XML/RPC/Server.php');

require(UPMS_PATH.'/lib/pear/Date.php');


class UpgradePackageManagerServer extends UpgradePackageManager
{
    protected $xmlrpcError;
    protected $upmsError;

    function checkID($params)
    {
        global $XML_RPC_erruser;

        $aParams = XML_RPC_decode($params->getParam(0));

        if (!empty($aParams))
        {
            $id = $aParams['changeset_id'];

            $row = $this->_getRowByID($id);
            if ($row)
            {
                return new XML_RPC_Response(XML_RPC_encode(
                    $row
                ));
            }
        }
        if (!empty($this->xmlrpcError))
            return new XML_RPC_Response(XML_RPC_encode($this->xmlrpcError));

        if (!empty($this->upmsError))
            return new XML_RPC_Response(XML_RPC_encode($this->upmsError));

        return new XML_RPC_Response(0, $XML_RPC_erruser, "No ID");
    }

    function getNextID()
    {
        global $XML_RPC_erruser;

        $result = $this->_getLastID();

        if ($result)
        {
            $result++;
            return new XML_RPC_Response(XML_RPC_encode(
                $result
            ));
        }

        if (!empty($this->xmlrpcError))
            return new XML_RPC_Response(XML_RPC_encode($this->xmlrpcError));

        if (!empty($this->upmsError))
            return new XML_RPC_Response(XML_RPC_encode($this->upmsError));

        return new XML_RPC_Response(0, $XML_RPC_erruser, "Error fetching next ID");
    }

    function registerID($params)
    {
        global $XML_RPC_erruser;

        $aParams = XML_RPC_decode($params->getParam(0));

        if (!empty($aParams))
        {
            $id         = $aParams['changeset_id'];
            $name       = $aParams['user_name'];
            $comments   = $aParams['comments'];

            $result = $this->_insertID($id, $name, $comments);

            if ($result)
            {
                $row = $this->_getRowByID($id);
                if ($row)
                {
                    return new XML_RPC_Response(XML_RPC_encode($row
                    ));
                }
            }

        }
        if (!empty($this->xmlrpcError))
            return new XML_RPC_Response(XML_RPC_encode($this->xmlrpcError));

        if (!empty($this->upmsError))
            return new XML_RPC_Response(XML_RPC_encode($this->upmsError));

        return new XML_RPC_Response(0, $XML_RPC_erruser, "Error registering schema version ID");
    }

    function _insertID($id, $user, $comments)
    {
        $query = "INSERT INTO changesets
                    (id, user, comments)
                    VALUES
                    ({$id}, '{$user}', '{$comments}')
                 ";
        $result = $this->mdb2->exec($query);

        if (PEAR::isError($result))
        {
            $this->upmsError = $result->getCode();
            return false;
        }
        $result = intval($result);
        if (!is_int($result))
        {
            $this->upmsError = 'Not a valid integer: '.$result;
            return false;
        }
        return $result;
    }

    function _getRowByID($id)
    {
        $query = 'SELECT * FROM changesets
                    WHERE id='.$id;
        $row = $this->mdb2->getAssoc($query);
        if (PEAR::isError($row))
        {
            $this->upmsError = $row->getUserinfo();
            return false;
        }
        return $row;
    }

    function _getLastID()
    {
        $query = 'SELECT id FROM changesets
                    ORDER BY id DESC';
        $id = $this->mdb2->getOne($query);
        if (PEAR::isError($id))
        {
            $this->upmsError = $id->getUserinfo();
            return false;
        }
        return intval($id);
    }

    function errorHandler($errno, $errstr, $errfile, $errline)
    {
        global $XML_RPC_erruser;

        if ($errno & (E_ERROR|E_USER_ERROR))
            $this->xmlrpcError = new XML_RPC_Response(0, $XML_RPC_erruser + 100,
                "Error in '$errfile' at line $errline: $errstr");
    }

    function start()
    {
        set_error_handler(array($this, 'errorHandler'));

        $server = new XML_RPC_Server(
            array(
                'OXUPMS.registerID' => array(
                    'function' => array($this, 'registerID'),
                    'signature' => array(
                        array('struct', 'struct')
                        ),
                    ),
                'OXUPMS.getNextID' => array(
                    'function' => array($this, 'getNextID')
                    ),
                'OXUPMS.checkID' => array(
                    'function' => array($this, 'checkID'),
                    'signature' => array(
                        array('struct', 'struct')
                        ),
                    ),
                1,
            )
        );
        $server->debug = 0;
        //$server->echoInput();
    }
}

?>
