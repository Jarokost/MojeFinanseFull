<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Incomes;
use \App\Models\Expenses;
use \App\Models\IncomesCategoryAssignedToUsers;
use \App\Models\ExpensesCategoryAssignedToUsers;
use \App\Models\PaymentMethodsAssignedToUsers;

/**
 * Balance controller (example)
 *
 * PHP version 7.0
 */
class Balance extends Authenticated
{
    /**
     * incomes table
     * 
     * @var array
     */
    public $incomes;

    /**
     * expenses table
     * 
     * @var array
     */
    public $expenses;
    
    /**
     * incomes sum grouped by categories
     * 
     * @var array
     */
    public $incomes_sum_cat;

    /**
     * expenses sum grouped by categories
     * 
     * @var array
     */
    public $expenses_sum_cat;

    /**
     * incomes sum
     * 
     * @var array
     */
    public $incomes_sum;

    /**
     * expenses sum
     * 
     * @var array
     */
    public $expenses_sum;

    /**
     * expenses categories
     * 
     * @var array
     */
    public $expenses_categories;

    /**
     * expenses payment methods
     * 
     * @var array
     */
    public $expenses_payment_methods;

    /**
     * incomes categories
     * 
     * @var array
     */
    public $incomes_categories;

    /**
     * date start
     * 
     * @var string
     */
    public $date_start;

    /**
     * date start
     * 
     * @var string
     */
    public $date_end;

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * functions
     * 
     * @return void
     */
    private function queries($date_start, $date_end)
    {
        $user_id = $_SESSION['user_id'];
        $this->date_start = $date_start;
        $this->date_end = $date_end;

        $this->expenses_categories = ExpensesCategoryAssignedToUsers::getCategoriesAssignedToUser($user_id);
        $this->expenses_payment_methods = PaymentMethodsAssignedToUsers::getCategoriesAssignedToUser($user_id);
        $this->incomes_categories = IncomesCategoryAssignedToUsers::getCategoriesAssignedToUser($user_id);

        $this->incomes = Incomes::getIncomes($user_id, $date_start, $date_end);
        $this->expenses = Expenses::getExpenses($user_id, $date_start, $date_end);
        $this->incomes_sum_cat = Incomes::getIncomesSumGroupedByCategories($user_id, $date_start, $date_end);
        $this->expenses_sum_cat = Expenses::getExpensesSumGroupedByCategories($user_id, $date_start, $date_end);
        $this->incomes_sum = Incomes::getIncomesSum($user_id, $date_start, $date_end);
        $this->expenses_sum = Expenses::getExpensesSum($user_id, $date_start, $date_end);
    }

    /**
     * Balance index
     *
     * @return void
     */
    public function indexAction()
    {
        $d=strtotime("-30 Days");
        $date_start = date("Y-m-d", $d);
        $date_end = date("Y-m-d");

        $this->queries($date_start, $date_end);

        View::renderTemplate('Balance/index.html', [
            'balance' => $this,
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
        $date_start = date("Y-m-01");
        $date_end = date("Y-m-t");

        $this->queries($date_start, $date_end);

        View::renderTemplate('Balance/index.html', [
            'balance' => $this,
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
        $d=strtotime("first day of last month");
        $date_start = date("Y-m-d", $d);
        $d=strtotime("last day of last month");
        $date_end = date("Y-m-d", $d);

        $this->queries($date_start, $date_end);

        View::renderTemplate('Balance/index.html', [
            'balance' => $this,
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
        $date_start = date($_POST['dateFrom']);
        $date_end = date($_POST['dateTo']);

        $this->queries($date_start, $date_end);

        View::renderTemplate('Balance/index.html', [
            'balance' => $this,
            'action' => $date_start . ' - ' . $date_end 
        ]);
    }

    /**
     * 
     */
    public function foo()
    {
        $input = json_decode(file_get_contents('php://input'), true);

        $user_id = $_SESSION['user_id'];

        $date_start = $input['date_start'];
        $date_end = $input['date_end'];

        $data['incomes_category_sum'] = Incomes::getIncomesSumGroupedByCategories($user_id, $date_start, $date_end);
        $data['expenses_category_sum'] = Expenses::getExpensesSumGroupedByCategories($user_id, $date_start, $date_end);

        echo json_encode($data);
        exit;
    }
}
