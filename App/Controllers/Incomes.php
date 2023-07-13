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

            Flash::addMessage('Dodano przychód: ' . $income->date_of_income . ' ' . $income->income_comment . ' ' . number_format($income->amount, 2, '.', '') . '[PLN]' );

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
        $income = new \App\Models\Incomes($post_fetch_promise);
        $data['success'] = $income->updateTableRowAjax();
        $data['errors'] = $income->errors;

        if ($income->errors == NULL) {
            $data['flash_message_body'][0] = 'dokonano zmian przychodu: ' 
            . $income->date_of_income . ' '
            . IncomesCategoryAssignedToUsers::getCategoryName($income->income_category_assigned_to_user_id) . ' '
            . $income->amount . '[PLN] opis: '
            . $income->income_comment;
            $data['flash_message_type'][0] = 'success';
        } else {
            $data['flash_message_body'][0] = 'nie udało się dokonać zmian przychodu';
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
        $income = \App\Models\Incomes::getIncomeById($row_id);
        \App\Models\Incomes::removeTableRowAjax($row_id);

        $data = [];
        $data = $this->queries($data);
        $data['flash_message_body'][0] = 'usunięto przychód: ' 
            . $income->date_of_income . ' '
            . IncomesCategoryAssignedToUsers::getCategoryName($income->income_category_assigned_to_user_id) . ' '
            . $income->amount . '[PLN] opis: '
            . $income->income_comment;
            $data['flash_message_type'][0] = 'success';

        echo json_encode($data);
        exit;
    }

}
