<?php
// controller
function list_() : void
{
    $conn = connectMysql();
    if (isset($_GET['order'])) {
        setOrder(RECORD, $_GET['order']);
    }
    $active_records = listRecords($conn);
    $data = [
        'active_records' => $active_records
    ];
    view("records", $data);
}
?>
