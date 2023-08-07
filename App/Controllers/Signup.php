<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Models\IncomesCategoryAssignedToUsers;
use \App\Models\ExpensesCategoryAssignedToUsers;
use \App\Models\PaymentMethodsAssignedToUsers;
use \App\Models\Expenses;
use \App\Models\Incomes;
use \App\ExpensesTestRecords;
use \App\IncomesTestRecords;
use \App\Config;

/**
 * Signup controller
 *
 * PHP version 7.0
 */
class Signup extends \Core\Controller
{
    /**
     * Show the signup page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

    /**
     * Sign up a new user
     *
     * @return void
     */
    public function createAction()
    {
        $user = new User($_POST);

        if ($user->save()) {

            $lastUserId = $user->getLastUserId();

            IncomesCategoryAssignedToUsers::fillCategoriesAssignedToUserWithDefault($lastUserId['id']);
            ExpensesCategoryAssignedToUsers::fillCategoriesAssignedToUserWithDefault($lastUserId['id']);
            PaymentMethodsAssignedToUsers::fillCategoriesAssignedToUserWithDefault($lastUserId['id']);

            if (in_array($user->email, Config::TEST_EMAILS, true)) {
                $incomesCategoryMinId = IncomesCategoryAssignedToUsers::getCategoryIdMinValueForUserId($lastUserId['id']);
                $incomesCategoryMaxId = IncomesCategoryAssignedToUsers::getCategoryIdMaxValueForUserId($lastUserId['id']);
                $expensesCategoryMinId = ExpensesCategoryAssignedToUsers::getCategoryIdMinValueForUserId($lastUserId['id']);
                $expensesCategoryMaxId = ExpensesCategoryAssignedToUsers::getCategoryIdMaxValueForUserId($lastUserId['id']);
                $paymentMethodMinId = PaymentMethodsAssignedToUsers::getCategoryIdMinValueForUserId($lastUserId['id']);
                $paymentMethodMaxId = PaymentMethodsAssignedToUsers::getCategoryIdMaxValueForUserId($lastUserId['id']);

                $expensesRecords = new ExpensesTestRecords();
                $incomesRecords = new IncomesTestRecords();
                // Expenses::addRandom(10, $lastUserId['id'], $expensesCategoryMinId, $expensesCategoryMaxId, $paymentMethodMinId, $paymentMethodMaxId);
                // Incomes::addRandom(10, $lastUserId['id'], $incomesCategoryMinId, $incomesCategoryMaxId);
                Expenses::addRecordsFromTestFile($lastUserId['id'], $expensesCategoryMinId, $paymentMethodMinId, $expensesRecords->records);
                Incomes::addRecordsFromTestFile($lastUserId['id'], $incomesCategoryMinId, $incomesRecords->records);
            }
            
            $user->sendActivationEmail();

            $this->redirect('/signup/success');

        } else {

            View::renderTemplate('Signup/new.html', [
                'user' => $user
            ]);

        }

    }

    /**
     * Show the signup success page
     *
     * @return void
     */
    public function successAction()
    {
        View::renderTemplate('Signup/success.html');
    }

    /**
     * Activate a new account
     *
     * @return void
     */
    public function activateAction()
    {
        User::activate($this->route_params['token']);

        $this->redirect('/signup/activated');        
    }

    /**
     * Show the activation success page
     *
     * @return void
     */
    public function activatedAction()
    {
        View::renderTemplate('Signup/activated.html');
    }
}