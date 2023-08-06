<?php

namespace App;

use \App\IncomesTest;

class IncomesTestRecords {
    public $records = [];

    public function __construct() {
        $this->records[0] = new IncomesTest(1, 9456.23, date("Y-m-d", strtotime("+0 days",strtotime("-3 month", strtotime("first day of this month")))), "Wypłata");
        $this->records[1] = new IncomesTest(2, 326.21, date("Y-m-d", strtotime("+3 days",strtotime("-3 month", strtotime("first day of this month")))), "Odsetki z lokaty");
        $this->records[2] = new IncomesTest(3, 487.22, date("Y-m-d", strtotime("+20 days",strtotime("-3 month", strtotime("first day of this month")))), "Sprzedaż na Allegro");
        $this->records[3] = new IncomesTest(4, 3456.78, date("Y-m-d", strtotime("+15 days",strtotime("-3 month", strtotime("first day of this month")))), "Delegacja - dieta");

        $this->records[4] = new IncomesTest(1, 9456.23, date("Y-m-d", strtotime("+0 days",strtotime("-2 month", strtotime("first day of this month")))), "Wypłata");
        $this->records[5] = new IncomesTest(2, 326.21, date("Y-m-d", strtotime("+5 days",strtotime("-2 month", strtotime("first day of this month")))), "Odsetki z lokaty");
        $this->records[6] = new IncomesTest(3, 487.22, date("Y-m-d", strtotime("+20 days",strtotime("-2 month", strtotime("first day of this month")))), "Sprzedaż na Allegro");
        $this->records[7] = new IncomesTest(4, 3456.78, date("Y-m-d", strtotime("+15 days",strtotime("-2 month", strtotime("first day of this month")))), "Delegacja - dieta");
        
        $this->records[8] = new IncomesTest(1, 9456.23, date("Y-m-d", strtotime("+0 days",strtotime("-1 month", strtotime("first day of this month")))), "Wypłata");
        $this->records[9] = new IncomesTest(2, 326.21, date("Y-m-d", strtotime("+5 days",strtotime("-1 month", strtotime("first day of this month")))), "Odsetki z lokaty");
        $this->records[10] = new IncomesTest(3, 487.22, date("Y-m-d", strtotime("+20 days",strtotime("-1 month", strtotime("first day of this month")))), "Sprzedaż na Allegro");
        $this->records[11] = new IncomesTest(4, 3456.78, date("Y-m-d", strtotime("+15 days",strtotime("-1 month", strtotime("first day of this month")))), "Delegacja - dieta");
        
        $this->records[12] = new IncomesTest(1, 9456.23, date("Y-m-d", strtotime("+0 days",strtotime("+0 month", strtotime("first day of this month")))), "Wypłata");
        $this->records[13] = new IncomesTest(2, 326.21, date("Y-m-d", strtotime("+5 days",strtotime("+0 month", strtotime("first day of this month")))), "Odsetki z lokaty");
        $this->records[14] = new IncomesTest(3, 272.21, date("Y-m-d", strtotime("+20 days",strtotime("+0 month", strtotime("first day of this month")))), "Sprzedaż na Allegro");
        $this->records[15] = new IncomesTest(4, 54.43, date("Y-m-d", strtotime("+15 days",strtotime("+0 month", strtotime("first day of this month")))), "Delegacja - dieta");
        
        $this->records[16] = new IncomesTest(1, 9456.23, date("Y-m-d", strtotime("+0 days",strtotime("+1 month", strtotime("first day of this month")))), "Wypłata");
        $this->records[17] = new IncomesTest(2, 326.21, date("Y-m-d", strtotime("+5 days",strtotime("+1 month", strtotime("first day of this month")))), "Odsetki z lokaty");
        $this->records[18] = new IncomesTest(3, 487.22, date("Y-m-d", strtotime("+20 days",strtotime("+1 month", strtotime("first day of this month")))), "Sprzedaż na Allegro");
        $this->records[19] = new IncomesTest(4, 3456.78, date("Y-m-d", strtotime("+15 days",strtotime("+1 month", strtotime("first day of this month")))), "Delegacja - dieta");
    }
}