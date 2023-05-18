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
     * Balance index
     *
     * @return void
     */
    public function indexAction()
    {
        $incomes = Incomes::getIncomes($_SESSION['user_id'], "2023-05-01", "2023-05-31");
        $expenses = Expenses::getExpenses($_SESSION['user_id'], "2023-05-01", "2023-05-31");
        $expenses_sum = Expenses::getExpensesSumGroupedByCategories($_SESSION['user_id'], "2023-05-01", "2023-05-31");
        $incomes_sum = Incomes::getIncomesSumGroupedByCategories($_SESSION['user_id'], "2023-05-01", "2023-05-31");

        View::renderTemplate('Balance/index.html', [
            'incomes' => $incomes,
            'expenses' => $expenses,
            'expenses_sum' => $expenses_sum,
            'incomes_sum' => $incomes_sum
        ]);
    }
}
