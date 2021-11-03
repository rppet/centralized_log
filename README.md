# centralized_log
Centralized access log

## 示例代码
    $logServer = new Log();
    // 获取分表表名前缀
    $subTablePrefix = config('centralized_log.table_name');
    // logModel
    $logModel = new LogModel($subTablePrefix, config('centralized_log.type'));
    // 获取完整的表名
    $tableName = $logModel->getTable();
    
    // 如果分表不存在则新建表
    if (!$logServer->checkTableIsExists($subTablePrefix)){
        $createSql = "CREATE TABLE `{$tableName}` (
      `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增id',
      `url` varchar(255) NOT NULL DEFAULT '' COMMENT '访问url',
      `parameter` text NOT NULL COMMENT '访问参数',
      `way` varchar(50) NOT NULL COMMENT '访问方式',
      `user_id` int(10) NOT NULL COMMENT '访问者id',
      `request_time` int(10) NOT NULL COMMENT '访问时间',
      `create_time` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
      PRIMARY KEY (`id`),
      KEY `idx_user_id` (`user_id`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $logServer->createTable($createSql, $tableName);
    }
    
    //添加日志记录
    $logResult = $logServer->addLog($tableName, $userId);
