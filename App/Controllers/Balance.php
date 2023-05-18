<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\Incomes;

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

        View::renderTemplate('Balance/index.html', [
            'incomes' => $incomes
        ]);
    }
}
