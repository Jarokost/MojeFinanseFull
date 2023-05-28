<?php

namespace App\Controllers;

use \Core\View;
//use \App\Models\Expenses;
use \App\Models\ExpensesCategoryAssignedToUsers;
use App\Models\PaymentMethodsAssignedToUsers;
use \App\Flash;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
class Expenses extends Authenticated
{

    /**
     * display new income form
     *
     * @return void
     */
    public function newAction()
    {
        $arr['date_of_expense'] = date('Y-m-d');
        $arr['amount'] = '0.00';
        $expense = New \App\Models\Expenses($arr);
        $expenses_categories = ExpensesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);
        $methods = PaymentMethodsAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        View::renderTemplate('Expenses/new.html', [
            'expenses_categories' => $expenses_categories,
            'expense' => $expense,
            'payment_methods' => $methods
        ]);
    }

    /**
     * Add a new expense to database
     *
     * @return void
     */
    public function addAction()
    {
        $expense = New \App\Models\Expenses($_POST);
        if ($expense->add()) {

            Flash::addMessage('Dodano wydatek');

            $this->redirect('/expenses/new');

        } else {

            $expenses_categories = ExpensesCategoryAssignedToUsers::
            getCategoriesAssignedToUser($_SESSION['user_id']);
            $methods = PaymentMethodsAssignedToUsers::
            getCategoriesAssignedToUser($_SESSION['user_id']);

            View::renderTemplate('Expenses/new.html', [
                'expenses_categories' => $expenses_categories,
                'expense' => $expense,
                'payment_methods' => $methods
            ]);
        }
    }

    private function queries($data) {
        $user_id = $_SESSION['user_id'];
        $date_start = $_POST['date_start'];
        $date_end = $_POST['date_end'];

        $data['incomes_sum'] = \App\Models\Incomes::getIncomesSum($user_id, $date_start, $date_end);
        $data['expenses_sum'] = \App\Models\Expenses::getExpensesSum($user_id, $date_start, $date_end);

        return $data;
    }

    public function updateTableRowAjax()
    {
        $data = [];
        $expenses = new \App\Models\Expenses($_POST);
        $data['success'] = $expenses->updateTableRowAjax();;
        $data['errors'] = $expenses->errors;

        $data = $this->queries($data);

        echo json_encode($data);
        exit;
    }

    public function removeTableRowAjax()
    {
        \App\Models\Expenses::removeTableRowAjax();

        $data = [];
        $data = $this->queries($data);

        echo json_encode($data);
        exit;
    }

}
