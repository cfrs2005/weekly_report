<?php
require './common.php';
//实例化redis
$redis = new Redis();
//连接服务器
$conn = $redis->connect('localhost');
//授权
$redis->auth(REDIS_AUTH_PASSWORD);
