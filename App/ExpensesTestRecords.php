<?php

namespace App;

use \App\ExpensesTest;

class ExpensesTestRecords {
    public $records = [];

    public function __construct() {
        $this->records[0] = new ExpensesTest(1, 3, 158.76, $this->dateString("+1 days", "-3 month"), "Bilet miesięczny");
        $this->records[1] = new ExpensesTest(1, 1, 213.23, $this->dateString("+5 days", "-3 month"), "paliwo Shell");
        $this->records[2] = new ExpensesTest(1, 1, 222.21, $this->dateString("+21 days", "-3 month"), "paliwo Shell");
        $this->records[3] = new ExpensesTest(3, 3, 39.23, $this->dateString("+2 days", "-3 month"), "Zakupy spożywcze biedronka");
        $this->records[4] = new ExpensesTest(3, 3, 212.83, $this->dateString("+8 days", "-3 month"), "Zakupy spożywcze biedronka");
        $this->records[5] = new ExpensesTest(3, 3, 204.02, $this->dateString("+14 days", "-3 month"), "Zakupy spożywcze biedronka");
        $this->records[6] = new ExpensesTest(3, 3, 82.57, $this->dateString("+28 days", "-3 month"), "Zakupy spożywcze biedronka");
        $this->records[7] = new ExpensesTest(2, 3, 23.99, $this->dateString("+6 days", "-3 month"), "Wiedźmin - Ostatnie życzenie");
        $this->records[8] = new ExpensesTest(10, 3, 49.00, $this->dateString("+24 days", "-3 month"), "Basen");
        $this->records[9] = new ExpensesTest(9, 3, 22.00, $this->dateString("+26 days", "-3 month"), "Lody");
        $this->records[10] = new ExpensesTest(12, 3, 220.00, $this->dateString("+9 days", "-3 month"), "Oszczędności");
        $this->records[11] = new ExpensesTest(14, 3, 2225.20, $this->dateString("+9 days", "-3 month"), "Rata kredytu hipotecznego");
        $this->records[12] = new ExpensesTest(8, 3, 23.45, $this->dateString("+12 days", "-3 month"), "Rossmann");
        $this->records[13] = new ExpensesTest(5, 3, 66.00, $this->dateString("+9 days", "-3 month"), "Abonament Play");
        $this->records[14] = new ExpensesTest(5, 3, 69.00, $this->dateString("+9 days", "-3 month"), "Inea Internet + TV");

        $this->records[15] = new ExpensesTest(1, 3, 158.76, $this->dateString("+1 days", "-2 month"), "Bilet miesięczny");
        $this->records[16] = new ExpensesTest(1, 1, 238.43, $this->dateString("+6 days", "-2 month"), "paliwo Shell");
        $this->records[17] = new ExpensesTest(1, 1, 272.21, $this->dateString("+16 days", "-2 month"), "paliwo BP");
        $this->records[18] = new ExpensesTest(3, 3, 96.33, $this->dateString("+1 days", "-2 month"), "Zakupy spożywcze biedronka");
        $this->records[19] = new ExpensesTest(3, 3, 112.83, $this->dateString("+5 days", "-2 month"), "Zakupy spożywcze biedronka");
        $this->records[20] = new ExpensesTest(3, 3, 204.02, $this->dateString("+16 days", "-2 month"), "Zakupy spożywcze biedronka");
        $this->records[21] = new ExpensesTest(3, 3, 97.27, $this->dateString("+24 days", "-2 month"), "Zakupy spożywcze biedronka");
        $this->records[22] = new ExpensesTest(2, 3, 23.99, $this->dateString("+6 days", "-2 month"), "Wiedźmin - Sezon burz");
        $this->records[23] = new ExpensesTest(10, 3, 49.00, $this->dateString("+24 days", "-2 month"), "Basen");
        $this->records[24] = new ExpensesTest(9, 3, 22.00, $this->dateString("+26 days", "-2 month"), "Lody");
        $this->records[25] = new ExpensesTest(12, 3, 350.00, $this->dateString("+9 days", "-2 month"), "Oszczędności");
        $this->records[26] = new ExpensesTest(14, 3, 2224.20, $this->dateString("+9 days", "-2 month"), "Rata kredytu hipotecznego");
        $this->records[27] = new ExpensesTest(8, 3, 123.45, $this->dateString("+9 days", "-2 month"), "Rossmann");
        $this->records[28] = new ExpensesTest(5, 3, 66.00, $this->dateString("+9 days", "-2 month"), "Abonament Play");
        $this->records[29] = new ExpensesTest(5, 3, 69.00, $this->dateString("+9 days", "-2 month"), "Inea Internet + TV");

        $this->records[30] = new ExpensesTest(1, 3, 158.76, $this->dateString("+1 days", "-1 month"), "Bilet miesięczny");
        $this->records[31] = new ExpensesTest(1, 1, 228.43, $this->dateString("+3 days", "-1 month"), "paliwo Shell");
        $this->records[32] = new ExpensesTest(1, 1, 242.21, $this->dateString("+17 days", "-1 month"), "paliwo BP");
        $this->records[33] = new ExpensesTest(3, 3, 74.43, $this->dateString("+0 days", "-1 month"), "Zakupy spożywcze biedronka");
        $this->records[34] = new ExpensesTest(3, 3, 212.83, $this->dateString("+8 days", "-1 month"), "Zakupy spożywcze biedronka");
        $this->records[35] = new ExpensesTest(3, 3, 204.02, $this->dateString("+14 days", "-1 month"), "Zakupy spożywcze biedronka");
        $this->records[36] = new ExpensesTest(3, 3, 182.57, $this->dateString("+26 days", "-1 month"), "Zakupy spożywcze biedronka");
        $this->records[37] = new ExpensesTest(2, 3, 23.99, $this->dateString("+6 days", "-1 month"), "Wiedźmin - Miecz przeznaczenia");
        $this->records[38] = new ExpensesTest(10, 3, 49.00, $this->dateString("+24 days", "-1 month"), "Basen");
        $this->records[39] = new ExpensesTest(9, 3, 22.00, $this->dateString("+26 days", "-1 month"), "Lody");
        $this->records[40] = new ExpensesTest(12, 3, 100.00, $this->dateString("+10 days", "-1 month"), "Oszczędności");
        $this->records[41] = new ExpensesTest(14, 3, 2222.20, $this->dateString("+10 days", "-1 month"), "Rata kredytu hipotecznego");
        $this->records[42] = new ExpensesTest(8, 3, 113.45, $this->dateString("+16 days", "-1 month"), "Rossmann");
        $this->records[43] = new ExpensesTest(5, 3, 66.00, $this->dateString("+10 days", "-1 month"), "Abonament Play");
        $this->records[44] = new ExpensesTest(5, 3, 69.00, $this->dateString("+10 days", "-1 month"), "Inea Internet + TV");

        $this->records[45] = new ExpensesTest(1, 3, 158.76, $this->dateString("+1 days", "+0 month"), "Bilet miesięczny");
        $this->records[46] = new ExpensesTest(1, 1, 238.43, $this->dateString("+3 days", "+0 month"), "paliwo Shell");
        $this->records[47] = new ExpensesTest(1, 1, 272.21, $this->dateString("+17 days", "+0 month"), "paliwo BP");
        $this->records[48] = new ExpensesTest(3, 3, 54.43, $this->dateString("+0 days", "+0 month"), "Zakupy spożywcze biedronka");
        $this->records[49] = new ExpensesTest(3, 3, 112.83, $this->dateString("+8 days", "+0 month"), "Zakupy spożywcze biedronka");
        $this->records[50] = new ExpensesTest(3, 3, 204.02, $this->dateString("+14 days", "+0 month"), "Zakupy spożywcze biedronka");
        $this->records[51] = new ExpensesTest(3, 3, 82.57, $this->dateString("+26 days", "+0 month"), "Zakupy spożywcze biedronka");
        $this->records[52] = new ExpensesTest(2, 3, 23.99, $this->dateString("+6 days", "+0 month"), "Wiedźmin - Krew elfów");
        $this->records[53] = new ExpensesTest(10, 3, 49.00, $this->dateString("+24 days", "+0 month"), "Basen");
        $this->records[54] = new ExpensesTest(9, 3, 22.00, $this->dateString("+26 days", "+0 month"), "Lody");
        $this->records[55] = new ExpensesTest(12, 3, 100.00, $this->dateString("+10 days", "+0 month"), "Oszczędności");
        $this->records[56] = new ExpensesTest(14, 3, 2224.20, $this->dateString("+10 days", "+0 month"), "Rata kredytu hipotecznego");
        $this->records[57] = new ExpensesTest(8, 3, 123.45, $this->dateString("+12 days", "+0 month"), "Rossmann");
        $this->records[58] = new ExpensesTest(5, 3, 66.00, $this->dateString("+10 days", "+0 month"), "Abonament Play");
        $this->records[59] = new ExpensesTest(5, 3, 69.00, $this->dateString("+10 days", "+0 month"), "Inea Internet + TV");

        $this->records[60] = new ExpensesTest(1, 3, 158.76, $this->dateString("+1 days", "+1 month"), "Bilet miesięczny");
        $this->records[61] = new ExpensesTest(1, 1, 238.43, $this->dateString("+6 days", "+1 month"), "paliwo Shell");
        $this->records[62] = new ExpensesTest(1, 1, 272.21, $this->dateString("+20 days", "+1 month"), "paliwo BP");
        $this->records[63] = new ExpensesTest(3, 3, 54.43, $this->dateString("+3 days", "+1 month"), "Zakupy spożywcze biedronka");
        $this->records[64] = new ExpensesTest(3, 3, 112.83, $this->dateString("+9 days", "+1 month"), "Zakupy spożywcze biedronka");
        $this->records[65] = new ExpensesTest(3, 3, 204.02, $this->dateString("+16 days", "+1 month"), "Zakupy spożywcze biedronka");
        $this->records[66] = new ExpensesTest(3, 3, 82.57, $this->dateString("+27 days", "+1 month"), "Zakupy spożywcze biedronka");
        $this->records[67] = new ExpensesTest(2, 3, 23.99, $this->dateString("+6 days", "+1 month"), "Wiedźmin - Czas pogardy");
        $this->records[68] = new ExpensesTest(10, 3, 49.00, $this->dateString("+24 days", "+1 month"), "Basen");
        $this->records[69] = new ExpensesTest(9, 3, 22.00, $this->dateString("+26 days", "+1 month"), "Lody");
        $this->records[70] = new ExpensesTest(12, 3, 100.00, $this->dateString("+10 days", "+1 month"), "Oszczędności");
        $this->records[71] = new ExpensesTest(14, 3, 2224.20, $this->dateString("+10 days", "+1 month"), "Rata kredytu hipotecznego");
        $this->records[72] = new ExpensesTest(8, 3, 123.45, $this->dateString("+12 days", "+1 month"), "Rossmann");
        $this->records[73] = new ExpensesTest(5, 3, 66.00, $this->dateString("+10 days", "+1 month"), "Abonament Play");
        $this->records[74] = new ExpensesTest(5, 3, 69.00, $this->dateString("+10 days", "+1 month"), "Inea Internet + TV");

    }

    function dateString($day, $month) {
        return date("Y-m-d", strtotime($day, strtotime($month, strtotime("first day of this month"))));
    }
}