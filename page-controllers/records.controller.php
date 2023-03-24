<?php
// controller
$conn = connectMysql();
if (isset($_GET['order'])) {
    setOrder(RECORD, $_GET['order']);
}

$active_records = listRecords($conn);
?>
