<?php

namespace App\Models;

use PDO;
use \App\Config;
use \Core\View;

/**
 * Incomes model
 *
 * PHP version 8.2
 */
class Incomes extends \Core\Model
{
    /**
     * incomes table id
     * 
     * @var string
     */
    public $id;

    /**
     * incomes table user_id
     * 
     * @var string
     */
    public $user_id;

    /**
     * incomes table income_category_assigned_to_user_id
     * 
     * @var string
     */
    public $income_category_assigned_to_user_id;

    /**
     * incomes table amount
     * 
     * @var string
     */
    public $amount;

    /**
     * incomes table date_of_income
     * 
     * @var string
     */
    public $date_of_income;

    /**
     * incomes table income_comment
     * 
     * @var string
     */
    public $income_comment;

    /**
     * Error messages
     *
     * @var array
     */
    public $errors = [];

    /**
     * Class constructor
     *
     * @param array $data  Initial property values (optional)
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    /**
     * Save the user model with the current property values
     *
     * @return boolean  True if the user was saved, false otherwise
     */
    public function add()
    {
        $this->validate();

        if (empty($this->errors)) {

            $user_id = $_SESSION['user_id'];
									 
            $sql = 'INSERT INTO incomes (user_id, income_category_assigned_to_user_id, amount, date_of_income, income_comment)
                    VALUES (:user_id, :income_category_assigned_to_user_id, :amount, :date_of_income, :income_comment)';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindValue(':income_category_assigned_to_user_id', $this->income_category_assigned_to_user_id, PDO::PARAM_STR);
            $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $stmt->bindValue(':date_of_income', $this->date_of_income, PDO::PARAM_STR);
            $stmt->bindValue(':income_comment', $this->income_comment, PDO::PARAM_STR);            

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Validate current property values, adding valiation error messages to the errors array property
     *
     * @return void
     */
    public function validate()
    {
        // Amount
        if (floatval($this->amount) <= 0.0) {
            $this->errors[] = 'Kwota jest zbyt niska';
        }
        if (floatval($this->amount) > 999999.99) {
            $this->errors[] = 'Kwota jest zbyt wysoka';
        }
        if ($this->income_category_assigned_to_user_id === 'wybierz') {
            $this->errors[] = 'Nie wybrano kategorii';
        }
    }
}