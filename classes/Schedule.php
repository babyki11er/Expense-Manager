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

class Schedule
{
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

    public function __construct(int $item_id, int $qty, string $date, string $note, mysqli $conn = null)
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

    public static function getScheduleById(int $id, mysqli $conn)
    {
        // do select query
        // $schedule = new Schedule();
        $stmt = $conn->prepare("SELECT * FROM pending WHERE id=?;");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            // dd($stmt->fetch(), true);
            $result = $stmt->get_result();
            dd($result->fetch_object("Schedule"));
            return null;
        } else {
            return null;
        }
    }

    public static function listSchedules(mysqli $conn): array
    {
        // returns array of existing listSchedules
        return [];
    }

    private static function validateSchedule(Schedule $schedule): bool
    {
        return true;
    }

    public function dbSave(): int
    {
        $stmt = $this->conn->prepare("INSERT INTO pending (item_id, qty, date, note) VALUES (?, ?, ?, ?);");
        $stmt->bind_param("iiss", $this->item_id, $this->qty, $this->date, $this->note);
        if ($stmt->execute()) {
            $this->db_id = $this->conn->insert_id;
            return $this->db_id;
        } else {
            -1;
        }
    }

    public function dbDelete(): int
    // returns the id of deleted id
    // works only if db_id is not -1, ie, if the schedule is saved into the db
    {
        if ($this->inDb()) {
            $stmt = $this->conn->prepare("DELETE FROM pending WHERE id=?;");
            $stmt->bind_param("i", $this->db_id);
            if ($stmt->execute()) {
                $this->db_id = -1;
                return $this->db_id;
            }
        }
        return -1;
    }

    public function dbUpdate(Schedule $updated_schedule): ?Schedule
    // works only if db_id is not -1, ie, if the schedule is saved into the db
    {
        // wtf code, yellow?
        if ($this->inDb() && Schedule::validateSchedule($updated_schedule)) {
            $this->dbDelete();
            $id = $updated_schedule->dbSave();
            $updated_schedule->db_id = $id;
            return $updated_schedule;
        }
        return null;
    }

    private function inDb(): bool
    // check if the current object is saved in database
    {
        return $this->db_id != -1;
    }
    public function apply(): int
    // returns the id of inserted record
    {

        return 0;
    }

    public function display(): void
    {
        dd((array) $this);
    }
}
