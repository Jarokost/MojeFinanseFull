<?php

namespace App\Controllers;

use \Core\View;
//use \App\Models\Incomes;
use \App\Models\IncomesCategoryAssignedToUsers;
use \App\Flash;

/**
 * Items controller (example)
 *
 * PHP version 7.0
 */
class Incomes extends Authenticated
{

    /**
     * display new income form
     *
     * @return void
     */
    public function newAction()
    {
        $arr['date_of_income'] = date('Y-m-d');
        $arr['amount'] = '0.00';
        $income = New \App\Models\Incomes($arr);
        $categories = IncomesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        View::renderTemplate('Incomes/new.html', [
            'income_categories' => $categories,
            'income' => $income
        ]);
    }

    /**
     * Add a new income to database
     *
     * @return void
     */
    public function addAction()
    {
        $income = New \App\Models\Incomes($_POST);
        if ($income->add()) {

            Flash::addMessage('Dodano nowy przychód');

            $this->redirect('/Incomes/new');

        } else {

            $categories = IncomesCategoryAssignedToUsers::
            getCategoriesAssignedToUser($_SESSION['user_id']);

            View::renderTemplate('Incomes/new.html', [
                'income_categories' => $categories,
                'income' => $income
            ]);
        }
    }

}