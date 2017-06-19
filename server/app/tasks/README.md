# Task

## how to run?
### single task
php init.php task-name method param1 param2 param3

Such as:
php init.php test main a b c

### multi tasks, depend on swoole
php multi.php father-task-name:method:param1,param2,param3 child-task-name

Such as:
php multi.php test2:main:a,b,c test
