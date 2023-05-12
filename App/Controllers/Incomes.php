<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\IncomesCategoryAssignedToUsers;

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
        $categories = IncomesCategoryAssignedToUsers::
        getCategoriesAssignedToUser($_SESSION['user_id']);

        View::renderTemplate('Incomes/new.html', [
            'income_categories' => $categories
        ]);
    }

    /**
     * Add a new income to database
     *
     * @return void
     */
    public function insertAction()
    {
        echo "new action";
    }

}
