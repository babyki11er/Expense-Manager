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
<!-- <link rel="stylesheet" href="./css/style.css"> -->
<?php
// $categories = listItems($conn);
// _html_log("hello world");
// dd($categories);
$values = [
	'item_id' => 67,
	'qty' => 1,
	'note' => 'updated',
	'date' => '2023-02-22'
];
// db_Insert($conn, RECORD, $values);
// _makeInsertStatement(RECORD, $values);
// echo "<br>";
// _makeUpdateStatement(RECORD, $values, $_GET['id']);
// echo "<br>";
// db_Update($conn, RECORD, $_GET['id'], $values);
// _makeSelectStatement(RECORD, ['archive' => 'active']);
// _makeDeleteStatement(RECORD, 20, ['state' => 33]);
// $id = existItem('shit', 200, 22, $conn);
// dd($id);
// echo display_money(2000000);
// echo "<br>";
// echo display_money(200000);
// echo "<br>";
// echo display_money(200);
// echo "<br>";
// echo display_money(50);

// function drive($conn) {
// 	$items = db_SelectAll($conn, ITEM, ['status'=>'active'], '*', 'name');
// 	$item_names = array_column($items, 'name');
// 	$counts = array_count_values($item_names);
// 	$counts_duplicate = array_filter($counts, function($val) {
// 		return $val > 1;
// 	});
// 	$duplicate_names = array_keys($counts_duplicate);
// 	dd($duplicate_names);
// }

// drive($conn);

// $items = db_SelectAll($conn, ITEM, ['status' => 'active'], '*',  'name');
// dd(get_duplicate($items, 'name'));
// dd(listItems($conn));
$s = 'heloisdlfkdsldklooo ';
echo $s['9'];