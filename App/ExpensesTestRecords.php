<?php

namespace App;

use \App\ExpensesTest;

class ExpensesTestRecords {
    public $records = [];

    public function __construct() {
        $this->records[0] = new ExpensesTest(1, 3, 158.76, date("Y-m-d", strtotime("+1 days",strtotime("-3 month", strtotime("first day of this month")))), "Bilet miesięczny");
        $this->records[1] = new ExpensesTest(1, 1, 238.43, date("Y-m-d", strtotime("+3 days",strtotime("-3 month", strtotime("first day of this month")))), "paliwo Shell");
        $this->records[2] = new ExpensesTest(1, 1, 272.21, date("Y-m-d", strtotime("+17 days",strtotime("-3 month", strtotime("first day of this month")))), "paliwo BP");
        $this->records[3] = new ExpensesTest(3, 3, 54.43, date("Y-m-d", strtotime("+0 days",strtotime("-3 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[4] = new ExpensesTest(3, 3, 112.83, date("Y-m-d", strtotime("+8 days",strtotime("-3 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[5] = new ExpensesTest(3, 3, 204.02, date("Y-m-d", strtotime("+14 days",strtotime("-3 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[6] = new ExpensesTest(3, 3, 82.57, date("Y-m-d", strtotime("+26 days",strtotime("-3 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[7] = new ExpensesTest(2, 3, 23.99, date("Y-m-d", strtotime("+6 days",strtotime("-3 month", strtotime("first day of this month")))), "Wiedźmin - Ostatnie życzenie");
        $this->records[8] = new ExpensesTest(10, 3, 49.00, date("Y-m-d", strtotime("+24 days",strtotime("-3 month", strtotime("first day of this month")))), "Basen");
        $this->records[9] = new ExpensesTest(9, 3, 22.00, date("Y-m-d", strtotime("+26 days",strtotime("-3 month", strtotime("first day of this month")))), "Lody");
        $this->records[10] = new ExpensesTest(12, 3, 100.00, date("Y-m-d", strtotime("+10 days",strtotime("-3 month", strtotime("first day of this month")))), "Oszczędności");
        $this->records[11] = new ExpensesTest(14, 3, 2224.20, date("Y-m-d", strtotime("+10 days",strtotime("-3 month", strtotime("first day of this month")))), "Rata kredytu hipotecznego");
        $this->records[12] = new ExpensesTest(8, 3, 123.45, date("Y-m-d", strtotime("+12 days",strtotime("-3 month", strtotime("first day of this month")))), "Rossmann");
        $this->records[13] = new ExpensesTest(5, 3, 66.00, date("Y-m-d", strtotime("+10 days",strtotime("-3 month", strtotime("first day of this month")))), "Abonament Play");
        $this->records[14] = new ExpensesTest(5, 3, 69.00, date("Y-m-d", strtotime("+10 days",strtotime("-3 month", strtotime("first day of this month")))), "Inea Internet + TV");

        $this->records[16] = new ExpensesTest(1, 1, 238.43, date("Y-m-d", strtotime("+3 days",strtotime("-2 month", strtotime("first day of this month")))), "paliwo Shell");
        $this->records[15] = new ExpensesTest(1, 3, 158.76, date("Y-m-d", strtotime("+1 days",strtotime("-2 month", strtotime("first day of this month")))), "Bilet miesięczny");
        $this->records[17] = new ExpensesTest(1, 1, 272.21, date("Y-m-d", strtotime("+17 days",strtotime("-2 month", strtotime("first day of this month")))), "paliwo BP");
        $this->records[18] = new ExpensesTest(3, 3, 54.43, date("Y-m-d", strtotime("+0 days",strtotime("-2 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[19] = new ExpensesTest(3, 3, 112.83, date("Y-m-d", strtotime("+8 days",strtotime("-2 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[20] = new ExpensesTest(3, 3, 204.02, date("Y-m-d", strtotime("+14 days",strtotime("-2 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[21] = new ExpensesTest(3, 3, 82.57, date("Y-m-d", strtotime("+26 days",strtotime("-2 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[22] = new ExpensesTest(2, 3, 23.99, date("Y-m-d", strtotime("+6 days",strtotime("-2 month", strtotime("first day of this month")))), "Wiedźmin - Ostatnie życzenie");
        $this->records[23] = new ExpensesTest(10, 3, 49.00, date("Y-m-d", strtotime("+24 days",strtotime("-2 month", strtotime("first day of this month")))), "Basen");
        $this->records[24] = new ExpensesTest(9, 3, 22.00, date("Y-m-d", strtotime("+26 days",strtotime("-2 month", strtotime("first day of this month")))), "Lody");
        $this->records[25] = new ExpensesTest(12, 3, 100.00, date("Y-m-d", strtotime("+10 days",strtotime("-2 month", strtotime("first day of this month")))), "Oszczędności");
        $this->records[26] = new ExpensesTest(14, 3, 2224.20, date("Y-m-d", strtotime("+10 days",strtotime("-2 month", strtotime("first day of this month")))), "Rata kredytu hipotecznego");
        $this->records[27] = new ExpensesTest(8, 3, 123.45, date("Y-m-d", strtotime("+12 days",strtotime("-2 month", strtotime("first day of this month")))), "Rossmann");
        $this->records[28] = new ExpensesTest(5, 3, 66.00, date("Y-m-d", strtotime("+10 days",strtotime("-2 month", strtotime("first day of this month")))), "Abonament Play");
        $this->records[29] = new ExpensesTest(5, 3, 69.00, date("Y-m-d", strtotime("+10 days",strtotime("-2 month", strtotime("first day of this month")))), "Inea Internet + TV");

        $this->records[30] = new ExpensesTest(1, 3, 158.76, date("Y-m-d", strtotime("+1 days",strtotime("-1 month", strtotime("first day of this month")))), "Bilet miesięczny");
        $this->records[31] = new ExpensesTest(1, 1, 238.43, date("Y-m-d", strtotime("+3 days",strtotime("-1 month", strtotime("first day of this month")))), "paliwo Shell");
        $this->records[32] = new ExpensesTest(1, 1, 272.21, date("Y-m-d", strtotime("+17 days",strtotime("-1 month", strtotime("first day of this month")))), "paliwo BP");
        $this->records[33] = new ExpensesTest(3, 3, 54.43, date("Y-m-d", strtotime("+0 days",strtotime("-1 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[34] = new ExpensesTest(3, 3, 112.83, date("Y-m-d", strtotime("+8 days",strtotime("-1 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[35] = new ExpensesTest(3, 3, 204.02, date("Y-m-d", strtotime("+14 days",strtotime("-1 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[36] = new ExpensesTest(3, 3, 82.57, date("Y-m-d", strtotime("+26 days",strtotime("-1 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[37] = new ExpensesTest(2, 3, 23.99, date("Y-m-d", strtotime("+6 days",strtotime("-1 month", strtotime("first day of this month")))), "Wiedźmin - Ostatnie życzenie");
        $this->records[38] = new ExpensesTest(10, 3, 49.00, date("Y-m-d", strtotime("+24 days",strtotime("-1 month", strtotime("first day of this month")))), "Basen");
        $this->records[39] = new ExpensesTest(9, 3, 22.00, date("Y-m-d", strtotime("+26 days",strtotime("-1 month", strtotime("first day of this month")))), "Lody");
        $this->records[40] = new ExpensesTest(12, 3, 100.00, date("Y-m-d", strtotime("+10 days",strtotime("-1 month", strtotime("first day of this month")))), "Oszczędności");
        $this->records[41] = new ExpensesTest(14, 3, 2224.20, date("Y-m-d", strtotime("+10 days",strtotime("-1 month", strtotime("first day of this month")))), "Rata kredytu hipotecznego");
        $this->records[42] = new ExpensesTest(8, 3, 123.45, date("Y-m-d", strtotime("+12 days",strtotime("-1 month", strtotime("first day of this month")))), "Rossmann");
        $this->records[43] = new ExpensesTest(5, 3, 66.00, date("Y-m-d", strtotime("+10 days",strtotime("-1 month", strtotime("first day of this month")))), "Abonament Play");
        $this->records[44] = new ExpensesTest(5, 3, 69.00, date("Y-m-d", strtotime("+10 days",strtotime("-1 month", strtotime("first day of this month")))), "Inea Internet + TV");

        $this->records[45] = new ExpensesTest(1, 3, 158.76, date("Y-m-d", strtotime("+1 days",strtotime("+0 month", strtotime("first day of this month")))), "Bilet miesięczny");
        $this->records[46] = new ExpensesTest(1, 1, 238.43, date("Y-m-d", strtotime("+3 days",strtotime("+0 month", strtotime("first day of this month")))), "paliwo Shell");
        $this->records[47] = new ExpensesTest(1, 1, 272.21, date("Y-m-d", strtotime("+17 days",strtotime("+0 month", strtotime("first day of this month")))), "paliwo BP");
        $this->records[48] = new ExpensesTest(3, 3, 54.43, date("Y-m-d", strtotime("+0 days",strtotime("+0 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[49] = new ExpensesTest(3, 3, 112.83, date("Y-m-d", strtotime("+8 days",strtotime("+0 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[50] = new ExpensesTest(3, 3, 204.02, date("Y-m-d", strtotime("+14 days",strtotime("+0 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[51] = new ExpensesTest(3, 3, 82.57, date("Y-m-d", strtotime("+26 days",strtotime("+0 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[52] = new ExpensesTest(2, 3, 23.99, date("Y-m-d", strtotime("+6 days",strtotime("+0 month", strtotime("first day of this month")))), "Wiedźmin - Ostatnie życzenie");
        $this->records[53] = new ExpensesTest(10, 3, 49.00, date("Y-m-d", strtotime("+24 days",strtotime("+0 month", strtotime("first day of this month")))), "Basen");
        $this->records[54] = new ExpensesTest(9, 3, 22.00, date("Y-m-d", strtotime("+26 days",strtotime("+0 month", strtotime("first day of this month")))), "Lody");
        $this->records[55] = new ExpensesTest(12, 3, 100.00, date("Y-m-d", strtotime("+10 days",strtotime("+0 month", strtotime("first day of this month")))), "Oszczędności");
        $this->records[56] = new ExpensesTest(14, 3, 2224.20, date("Y-m-d", strtotime("+10 days",strtotime("+0 month", strtotime("first day of this month")))), "Rata kredytu hipotecznego");
        $this->records[57] = new ExpensesTest(8, 3, 123.45, date("Y-m-d", strtotime("+12 days",strtotime("+0 month", strtotime("first day of this month")))), "Rossmann");
        $this->records[58] = new ExpensesTest(5, 3, 66.00, date("Y-m-d", strtotime("+10 days",strtotime("+0 month", strtotime("first day of this month")))), "Abonament Play");
        $this->records[59] = new ExpensesTest(5, 3, 69.00, date("Y-m-d", strtotime("+10 days",strtotime("+0 month", strtotime("first day of this month")))), "Inea Internet + TV");

        $this->records[60] = new ExpensesTest(1, 3, 158.76, date("Y-m-d", strtotime("+1 days",strtotime("+1 month", strtotime("first day of this month")))), "Bilet miesięczny");
        $this->records[61] = new ExpensesTest(1, 1, 238.43, date("Y-m-d", strtotime("+3 days",strtotime("+1 month", strtotime("first day of this month")))), "paliwo Shell");
        $this->records[62] = new ExpensesTest(1, 1, 272.21, date("Y-m-d", strtotime("+17 days",strtotime("+1 month", strtotime("first day of this month")))), "paliwo BP");
        $this->records[63] = new ExpensesTest(3, 3, 54.43, date("Y-m-d", strtotime("+0 days",strtotime("+1 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[64] = new ExpensesTest(3, 3, 112.83, date("Y-m-d", strtotime("+8 days",strtotime("+1 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[65] = new ExpensesTest(3, 3, 204.02, date("Y-m-d", strtotime("+14 days",strtotime("+1 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[66] = new ExpensesTest(3, 3, 82.57, date("Y-m-d", strtotime("+26 days",strtotime("+1 month", strtotime("first day of this month")))), "Zakupy spożywcze biedronka");
        $this->records[67] = new ExpensesTest(2, 3, 23.99, date("Y-m-d", strtotime("+6 days",strtotime("+1 month", strtotime("first day of this month")))), "Wiedźmin - Ostatnie życzenie");
        $this->records[68] = new ExpensesTest(10, 3, 49.00, date("Y-m-d", strtotime("+24 days",strtotime("+1 month", strtotime("first day of this month")))), "Basen");
        $this->records[69] = new ExpensesTest(9, 3, 22.00, date("Y-m-d", strtotime("+26 days",strtotime("+1 month", strtotime("first day of this month")))), "Lody");
        $this->records[70] = new ExpensesTest(12, 3, 100.00, date("Y-m-d", strtotime("+10 days",strtotime("+1 month", strtotime("first day of this month")))), "Oszczędności");
        $this->records[71] = new ExpensesTest(14, 3, 2224.20, date("Y-m-d", strtotime("+10 days",strtotime("+1 month", strtotime("first day of this month")))), "Rata kredytu hipotecznego");
        $this->records[72] = new ExpensesTest(8, 3, 123.45, date("Y-m-d", strtotime("+12 days",strtotime("+1 month", strtotime("first day of this month")))), "Rossmann");
        $this->records[73] = new ExpensesTest(5, 3, 66.00, date("Y-m-d", strtotime("+10 days",strtotime("+1 month", strtotime("first day of this month")))), "Abonament Play");
        $this->records[74] = new ExpensesTest(5, 3, 69.00, date("Y-m-d", strtotime("+10 days",strtotime("+1 month", strtotime("first day of this month")))), "Inea Internet + TV");

    }
}