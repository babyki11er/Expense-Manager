<?php
/* Record:

        item_id     int
        item_name   string(computed)
        qty         int
        cost        int(computed)
        cat_str     string(computed)
        cat_id      int(computed)
        date        str
        note        str
*/

class Schedule {
    private int $item_id;
    private string $item_name;
    private int $qty;
    private int $cost;
    private string $cat_str;
    private int $cat_id;
    private string $date;
    private string $note;
    private int $db_id = -1;
    private mysqli $conn;

    public function __construct(int $item_id, int $qty, string $date, string $note, mysqli $conn)
    {
        $this->item_id = $item_id;
        $this->qty = $qty;
        $this->date = $date;
        $this->note = $note;
        $this->conn = $conn;

        $item = getItemById($item_id, $this->conn);
        $this->item_name = $item['name'];
        $this->cost = $item['price'] * $this->qty;
        $this->cat_str = $item['cat_str'];
        $this->cat_id = $item['cat_id'];
    }

    public static function getScheduleById(int $id, mysqli $conn) : Schedule
    {
        // do select query
        $schedule = new Schedule();
        $schedule->db_id = $id;
        return $schedule;
    }

    public static function listSchedules(mysqli $conn) : array
    {
        // returns array of existing listSchedules
        return [];
    }

    private static function validateSchedule(Schedule $schedule) : bool
    {

    }

    public function dbSave() : int
    {
        $stmt = $this->conn->prepare("INSERT INTO schedule (item_id, qty, date, note) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("iiss", $this->item_id, $this->qty, $this->date, $this->note);
        return $this->conn->insert_id;
    }

    public function dbDelete() : int
    // returns the id of deleted id
    // works only if db_id is not -1, ie, if the schedule is saved into the db
    {

    }

    public function dbUpdate(Schedule $updated_schedule) : bool
    // works only if db_id is not -1, ie, if the schedule is saved into the db
    {

    }
    public function apply() : int
    // returns the id of inserted record
    {

        return 0;
    }

    public function getItemName() : string
    {
        return $this->item_name;
    }

    public function display() : void
    {
        dd((array) $this);
    }

}