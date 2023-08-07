<?php

namespace App;

use \App\IncomesTest;

class IncomesTestRecords {
    public $records = [];

    public function __construct() {
        $this->records[0] = new IncomesTest(1, 8223.87, $this->dateString("+0 days", "-3 month"), "Wypłata");
        $this->records[1] = new IncomesTest(2, 326.21, $this->dateString("+3 days", "-3 month"), "Odsetki z lokaty");
        $this->records[2] = new IncomesTest(3, 487.00, $this->dateString("+20 days", "-3 month"), "Sprzedaż na Allegro");
        $this->records[3] = new IncomesTest(4, 2802.95, $this->dateString("+15 days", "-3 month"), "Delegacja - dieta");

        $this->records[4] = new IncomesTest(1, 9456.23, $this->dateString("+0 days", "-2 month"), "Wypłata");
        $this->records[5] = new IncomesTest(2, 332.34, $this->dateString("+5 days", "-2 month"), "Odsetki z lokaty");
        $this->records[6] = new IncomesTest(3, 100.00, $this->dateString("+20 days", "-2 month"), "Sprzedaż na Allegro");
        $this->records[7] = new IncomesTest(4, 3456.78, $this->dateString("+15 days", "-2 month"), "Delegacja - dieta");
        
        $this->records[8] = new IncomesTest(1, 10102.02, $this->dateString("+0 days", "-1 month"), "Wypłata");
        $this->records[9] = new IncomesTest(2, 336.23, $this->dateString("+5 days", "-1 month"), "Odsetki z lokaty");
        $this->records[10] = new IncomesTest(3, 400.00, $this->dateString("+20 days", "-1 month"), "Sprzedaż na Allegro");
        $this->records[11] = new IncomesTest(4, 5213.98, $this->dateString("+15 days", "-1 month"), "Delegacja - dieta");
        
        $this->records[12] = new IncomesTest(1, 9658.32, $this->dateString("+0 days", "+0 month"), "Wypłata");
        $this->records[13] = new IncomesTest(2, 338.21, $this->dateString("+5 days", "+0 month"), "Odsetki z lokaty");
        $this->records[14] = new IncomesTest(3, 270.00, $this->dateString("+20 days", "+0 month"), "Sprzedaż na Allegro");
        $this->records[15] = new IncomesTest(4, 4354.33, $this->dateString("+15 days", "+0 month"), "Delegacja - dieta");
        
        $this->records[16] = new IncomesTest(1, 9921.07, $this->dateString("+0 days", "+1 month"), "Wypłata");
        $this->records[17] = new IncomesTest(2, 339.98, $this->dateString("+5 days", "+1 month"), "Odsetki z lokaty");
        $this->records[18] = new IncomesTest(3, 20.00, $this->dateString("+20 days", "+1 month"), "Sprzedaż na Allegro");
        $this->records[19] = new IncomesTest(4, 3744.46, $this->dateString("+15 days", "+1 month"), "Delegacja - dieta");
    }

    function dateString($day, $month) {
        return date("Y-m-d", strtotime($day, strtotime($month, strtotime("first day of this month"))));
    }
}