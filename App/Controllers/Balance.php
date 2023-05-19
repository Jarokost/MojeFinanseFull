<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\Incomes;
use \App\Models\Expenses;

/**
 * Balance controller (example)
 *
 * PHP version 7.0
 */
class Balance extends Authenticated
{
    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Balance index
     *
     * @return void
     */
    public function indexAction()
    {
        $user_id = $_SESSION['user_id'];

        $d=strtotime("-30 Days");
        $date_start = date("Y-m-d", $d);
        $date_end = date("Y-m-d");

        $incomes = Incomes::getIncomes($user_id, $date_start, $date_end);
        $expenses = Expenses::getExpenses($user_id, $date_start, $date_end);
        $expenses_sum_cat = Expenses::getExpensesSumGroupedByCategories($user_id, $date_start, $date_end);
        $incomes_sum_cat = Incomes::getIncomesSumGroupedByCategories($user_id, $date_start, $date_end);
        $incomes_sum = Incomes::getIncomesSum($user_id, $date_start, $date_end);
        $expenses_sum = Expenses::getExpensesSum($user_id, $date_start, $date_end);

        View::renderTemplate('Balance/index.html', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'expenses_sum_cat' => $expenses_sum_cat,
            'incomes_sum_cat' => $incomes_sum_cat,
            'expenses_sum' => $expenses_sum,
            'incomes_sum' => $incomes_sum,
            'action' => 'ostatnie 30 dni' 
        ]);
    }

    /**
     * Balance index
     *
     * @return void
     */
    public function indexCurrentMonthAction()
    {
        $user_id = $_SESSION['user_id'];

        $date_start = date("Y-m-01");
        $date_end = date("Y-m-d");

        $incomes = Incomes::getIncomes($user_id, $date_start, $date_end);
        $expenses = Expenses::getExpenses($user_id, $date_start, $date_end);
        $expenses_sum_cat = Expenses::getExpensesSumGroupedByCategories($user_id, $date_start, $date_end);
        $incomes_sum_cat = Incomes::getIncomesSumGroupedByCategories($user_id, $date_start, $date_end);
        $incomes_sum = Incomes::getIncomesSum($user_id, $date_start, $date_end);
        $expenses_sum = Expenses::getExpensesSum($user_id, $date_start, $date_end);

        View::renderTemplate('Balance/index.html', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'expenses_sum_cat' => $expenses_sum_cat,
            'incomes_sum_cat' => $incomes_sum_cat,
            'expenses_sum' => $expenses_sum,
            'incomes_sum' => $incomes_sum,
            'action' => 'bieżący miesiąc'
        ]);
    }

    /**
     * Balance index
     *
     * @return void
     */
    public function indexPreviousMonthAction()
    {
        $user_id = $_SESSION['user_id'];

        $d=strtotime("first day of last month");
        $date_start = date("Y-m-d", $d);
        $d=strtotime("last day of last month");
        $date_end = date("Y-m-d", $d);

        $incomes = Incomes::getIncomes($user_id, $date_start, $date_end);
        $expenses = Expenses::getExpenses($user_id, $date_start, $date_end);
        $expenses_sum_cat = Expenses::getExpensesSumGroupedByCategories($user_id, $date_start, $date_end);
        $incomes_sum_cat = Incomes::getIncomesSumGroupedByCategories($user_id, $date_start, $date_end);
        $incomes_sum = Incomes::getIncomesSum($user_id, $date_start, $date_end);
        $expenses_sum = Expenses::getExpensesSum($user_id, $date_start, $date_end);

        View::renderTemplate('Balance/index.html', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'expenses_sum_cat' => $expenses_sum_cat,
            'incomes_sum_cat' => $incomes_sum_cat,
            'expenses_sum' => $expenses_sum,
            'incomes_sum' => $incomes_sum,
            'action' => 'poprzedni miesiąc'
        ]);
    }

    /**
     * Balance index
     *
     * @return void
     */
    public function indexSelectedDatesAction()
    {
        $user_id = $_SESSION['user_id'];

        $date_start = date($_POST['dateFrom']);
        $date_end = date($_POST['dateTo']);

        $incomes = Incomes::getIncomes($user_id, $date_start, $date_end);
        $expenses = Expenses::getExpenses($user_id, $date_start, $date_end);
        $expenses_sum_cat = Expenses::getExpensesSumGroupedByCategories($user_id, $date_start, $date_end);
        $incomes_sum_cat = Incomes::getIncomesSumGroupedByCategories($user_id, $date_start, $date_end);
        $incomes_sum = Incomes::getIncomesSum($user_id, $date_start, $date_end);
        $expenses_sum = Expenses::getExpensesSum($user_id, $date_start, $date_end);

        View::renderTemplate('Balance/index.html', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'expenses_sum_cat' => $expenses_sum_cat,
            'incomes_sum_cat' => $incomes_sum_cat,
            'expenses_sum' => $expenses_sum,
            'incomes_sum' => $incomes_sum,
            'action' => $date_start . ' - ' . $date_end
        ]);
    }
}
