<?php

namespace App;

class IncomesTest {

    /**
     * 1    Salary
     * 2    Interest
     * 3    Allegro
     * 4    Another
     */
    public $income_category_assigned_to_user_id;
    public $amount;
    public $date_of_income;
    public $income_comment;

    public function __construct($income_category_assigned_to_user_id, $amount, $date_of_income, $income_comment) {
        $this->income_category_assigned_to_user_id = $income_category_assigned_to_user_id;
        $this->amount = $amount;
        $this->date_of_income = $date_of_income;
        $this->income_comment = $income_comment;
    }
}