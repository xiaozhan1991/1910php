<?php

   $redis = new Redis();

   //连接redis
   $redis->connect('127.0.0.1',6379);
   $redis->auth('123456abc');

   $k1 = 'name2';
   echo $redis->get($k1);
