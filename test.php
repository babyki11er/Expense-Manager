<?php
// require_once "./header.php";
require_once "./functions/functions.php";

$conn = connectMysql();

apiResponse(listCategories($conn));
