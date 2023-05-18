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
        $categories = ExpensesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);
        $methods = PaymentMethodsAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);
        
        View::renderTemplate('Expenses/new.html', [
            'expenses_categories' => $categories,
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

            Flash::addMessage('Dodano nowy przychód');

            $this->redirect('/Expenses/new');

        } else {

            $categories = ExpensesCategoryAssignedToUsers::
            getCategoriesAssignedToUser($_SESSION['user_id']);
            $methods = PaymentMethodsAssignedToUsers::
            getCategoriesAssignedToUser($_SESSION['user_id']);

            View::renderTemplate('Expenses/new.html', [
                'expenses_categories' => $categories,
                'expense' => $expense,
                'payment_methods' => $methods
            ]);
        }
    }

}
