<?php
// controller
function run_controller() : array
{
    $conn = connectMysql();
    if (isset($_GET['order'])) {
        setOrder(RECORD, $_GET['order']);
    }
    $active_records = listRecords($conn);
    return [
        'active_records' => $active_records
    ];
}
?>
