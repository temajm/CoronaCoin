<?php
include '../cc_api.php';
$ccoin = new CoronaCoin(..., '...');// Первый аргумент ID страницы. Второй аргумент секрет ключ созданный на страницы которую вы указали в первом аргументе.
var_dump($ccoin->getMyBalance());
?>