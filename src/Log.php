<?php
namespace Hanuas\CentralizedLog;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;

class Log
{
    /**
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Log constructor.
     */
    public function __construct()
    {
        $this->request = Request::instance();
    }

    /**
     * Notes:
     * @param $tableName
     * @param $userId
     * @return bool
     * DateTime:2021/11/3 5:03 下午
     */
    public function addLog($tableName, $userId = 0)
    {
        $logData = [
            'url' => $this->request->getPathInfo(),
            'parameter' => json_encode($this->request->all()),
            'way' => $this->request->getMethod(),
            'user_id' => $userId,
            'client_ip' => $this->request->getClientIp(),
            'description' => $this->request->input('log_description') ?? '',
            'request_time' => time(),
            'create_time' => date('Y-m-d H:i:s')
        ];

        return DB::table($tableName)->insert($logData);
    }

    /**
     * Notes:
     * @param string $table
     * @param string $connection
     * @return bool
     * DateTime:2021/11/3 5:06 下午
     */
    public function checkTableIsExists($table = '', $connection = '')
    {
        if (!$connection){
            $connection = 'mysql';
        }
        if (Schema::connection($connection)->hasTable($table)) {
            return true;
        }
        return false;
    }

    /**
     * Notes:
     * @param string $sql
     * @param string $table
     * @return bool
     * DateTime:2021/11/3 5:07 下午
     */
    public function createTable($sql = '', $table = '')
    {
        if ($this->checkTableIsExists($table)){
            return true;
        }
        if ($sql){
            return DB::statement($sql);
        }
        return true;
    }
}