<?php
$con = mysqli_init();
mysqli_ssl_set($con,NULL,NULL, "{path to CA cert}", NULL, NULL);
mysqli_real_connect($conn, "explorer-server.mysql.database.azure.com", "xdifhddbhh", "w8J523yFSqAcI5X$", "divinedb", 3306, MYSQLI_CLIENT_SSL);





?>