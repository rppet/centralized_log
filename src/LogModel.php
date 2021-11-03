<?php
namespace Hanuas\CentralizedLog;

class LogModel extends SubTableAbstract
{
    /**
     * LogModel constructor.
     * @param $tableName
     * @param string $type
     */
    public function __construct($tableName, $type = 'date')
    {
        parent::__construct();

        self::$prefixTable = $tableName;
        self::setTableIdentity($type);
    }
}