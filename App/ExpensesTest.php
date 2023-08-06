<?php

namespace App;

class ExpensesTest {

    /**
     * 1    Transport
     * 2    Books
     * 3    Food
     * 4	Apartments
     * 5	Telecommunication
     * 6	Health
     * 7	Clothes
     * 8	Hygiene
     * 9	Kids
     * 10	Recreation
     * 11	Trip
     * 12	Savings
     * 13	For Retirement
     * 14	Debt Repayment
     * 15	Gift
     * 16	Another
     */
    public $expense_category_assigned_to_user_id;

    /**
     * 1    Cash
     * 2	Debit Card
     * 3	Credit Card
     */
    public $payment_method_assigned_to_user_id;
    public $amount;
    public $date_of_expense;
    public $expense_comment;

    public function __construct($expense_category_assigned_to_user_id, $payment_method_assigned_to_user_id, $amount, $date_of_expense, $expense_comment) {
        $this->expense_category_assigned_to_user_id = $expense_category_assigned_to_user_id;
        $this->payment_method_assigned_to_user_id = $payment_method_assigned_to_user_id;
        $this->amount = $amount;
        $this->date_of_expense = $date_of_expense;
        $this->expense_comment = $expense_comment;
    }
}