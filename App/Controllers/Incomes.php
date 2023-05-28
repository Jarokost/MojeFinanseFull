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
            'income' => $income,
            'action' => 'new'
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

            $this->redirect('/incomes/new');

        } else {

            $categories = IncomesCategoryAssignedToUsers::
            getCategoriesAssignedToUser($_SESSION['user_id']);

            View::renderTemplate('Incomes/new.html', [
                'income_categories' => $categories,
                'income' => $income,
                'action' => 'add'
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
        $incomes = new \App\Models\Incomes($_POST);
        $data['success'] = $incomes->updateTableRowAjax();
        $data['errors'] = $incomes->errors;

        $data = $this->queries($data);

        echo json_encode($data);
        exit;
    }

    public function removeTableRowAjax()
    {
        \App\Models\Incomes::removeTableRowAjax();

        $data = [];
        $data = $this->queries($data);

        echo json_encode($data);
        exit;
    }

}
