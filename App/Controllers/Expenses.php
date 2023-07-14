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
     * user_id
     */

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

            Flash::addMessage('Dodano wydatek: ' . $expense->date_of_expense . ' ' . $expense->expense_comment . ' ' . number_format($expense->amount, 2, '.', '') . '[PLN]' ); 

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

        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        $user_id = $_SESSION['user_id'];

        $date_start = $post_fetch_promise['date_start'];
        $date_end = $post_fetch_promise['date_end'];

        $data['incomes_sum'] = \App\Models\Incomes::getIncomesSum($user_id, $date_start, $date_end);
        $data['expenses_sum'] = \App\Models\Expenses::getExpensesSum($user_id, $date_start, $date_end);

        return $data;
    }

    public function updateTableRowAjax()
    {
        $data = [];
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);
        $expense = new \App\Models\Expenses($post_fetch_promise);
        $data['success'] = $expense->updateTableRowAjax();
        $data['errors'] = $expense->errors;

        if ($expense->errors == NULL) {
            $data['flash_message_body'][0] = 'dokonano zmian wydatku: ' 
            . $expense->date_of_expense . ' '
            . ExpensesCategoryAssignedToUsers::getCategoryName($expense->expense_category_assigned_to_user_id) . ' '
            . $expense->amount . '[PLN] opis: '
            . $expense->expense_comment;
            $data['flash_message_type'][0] = 'success';
        } else {
            $data['flash_message_body'][0] = 'nie udało się dokonać zmian wydatku';
            $data['flash_message_type'][0] = 'warning';
        }

        $data = $this->queries($data);

        echo json_encode($data);
        exit;
    }

    public function removeTableRowAjax()
    {
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);
        $row_id = $post_fetch_promise['id'];
        $expense = \App\Models\Expenses::getExpenseById($row_id);
        \App\Models\Expenses::removeTableRowAjax($row_id);

        $data = [];
        $data = $this->queries($data);
        $data['flash_message_body'][0] = 'usunięto przychód: ' 
            . $expense->date_of_expense . ' '
            . ExpensesCategoryAssignedToUsers::getCategoryName($expense->expense_category_assigned_to_user_id) . ' '
            . $expense->amount . '[PLN] opis: '
            . $expense->expense_comment;
            $data['flash_message_type'][0] = 'success';

        echo json_encode($data);
        exit;
    }

    public function limitAction()
    {
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        $data = ExpensesCategoryAssignedToUsers::getLimit($_SESSION['user_id'], $post_fetch_promise['category_id'] );

        echo json_encode($data);
        exit;
    }

    public function categorySumAction()
    {
        $post_fetch_promise = json_decode(file_get_contents('php://input'), true);

        $date = strtotime($post_fetch_promise['date']);
        $date_start = date("Y-m-01", $date);
        $date_end = date("Y-m-t", $date);

        $data = \App\Models\Expenses::getExpensesSumForCategory($_SESSION['user_id'], $post_fetch_promise['category_id'], $date_start, $date_end);
        
        echo json_encode($data);
        exit;
    }
}
