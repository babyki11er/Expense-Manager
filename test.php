<?php
// require_once "./header.php";
require_once "./functions/functions.php";

$conn = connectMysql();

// echo db_InsertNewRecord($conn, 1, 1, 'hello world', '11-11-11');

// $i = getTotalIncome($conn);
// html_var_dump($i);

// $id = db_InsertNewIncome($conn, 20000, 'coffee', '11-11-11', '');
// html_var_dump($id);

// $id = addIncome(1000000, 'fix', '11-21-11000', 'hello world', $conn);
// echo $id;
// $total = getTotalOutcome($conn);
// echo $total;

// $id = $_GET['id'];
// db_SelectExistenceItem($conn, $id);
// $id = $_GET['id'];
// dd(_checkItem($id, $conn));
// $incomes = getTotalOutcome($conn);
// $items = listItems($conn);
?>
<link rel="stylesheet" href="./css/style.css">
<?php
$categories = listItems($conn);
_html_log("hello world");
dd($categories);