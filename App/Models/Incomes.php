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
     * incomes_category_assigned_to_users table name
     * 
     * @var string
     */
    public $category_name;

    /**
     * incomes sum grouped by category
     * 
     * @var string
     */
    public $category_amount_sum;

    /**
     * incomes sum total
     * 
     * @var string
     */
    public $amount_sum;

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

    /**
     * Select incomes from incomes table between dates
     * 
     * @return object
     */
    public static function getIncomes($user_id, $date_start, $date_end) 
    {
        $sql = 'SELECT i.id, i.amount, i.date_of_income, i.income_comment, iu.name AS category_name
                FROM incomes AS i, incomes_category_assigned_to_users AS iu
                WHERE i.user_id = :user_id 
                AND i.date_of_income BETWEEN :date_start AND :date_end
                AND i.income_category_assigned_to_user_id = iu.id
                ORDER BY i.date_of_income DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindValue(':date_start', $date_start, PDO::PARAM_STR);
        $stmt->bindValue(':date_end', $date_end, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Select incomes sum group by categories
     * 
     * @return array
     */
    public static function getIncomesSumGroupedByCategories($user_id, $date_start, $date_end)
    {
        $sql = 'SELECT iu.name AS category_name, SUM(i.amount) AS category_amount_sum
                FROM incomes AS i, incomes_category_assigned_to_users AS iu
                WHERE i.user_id = :user_id
                AND i.date_of_income BETWEEN :date_start AND :date_end
                AND i.income_category_assigned_to_user_id = iu.id 
                GROUP BY iu.name 
                ORDER BY category_amount_sum DESC';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindValue(':date_start', $date_start, PDO::PARAM_STR);
        $stmt->bindValue(':date_end', $date_end, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Select incomes sum
     * 
     * @return float
     */
    public static function getIncomesSum($user_id, $date_start, $date_end)
    {
        $sql = 'SELECT SUM(i.amount) AS amount_sum
                FROM incomes AS i
                WHERE i.user_id = :user_id
                AND i.date_of_income BETWEEN :date_start AND :date_end';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindValue(':date_start', $date_start, PDO::PARAM_STR);
        $stmt->bindValue(':date_end', $date_end, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Update income
     * 
     * @return bool
     */
    public function updateTableRowAjax() {

        $this->validate();

        if (empty($this->errors)) {
            $sql = 'UPDATE incomes
                    SET income_category_assigned_to_user_id = :income_category_assigned_to_user_id,
                        date_of_income = :date_of_income,
                        income_comment = :income_comment,
                        amount = :amount
                    WHERE id = :id';

            $db = static::getDB();
            $stmt = $db->prepare($sql);

            $stmt->bindValue(':income_category_assigned_to_user_id', $this->income_category_assigned_to_user_id, PDO::PARAM_INT);
            $stmt->bindValue(':date_of_income', $this->date_of_income, PDO::PARAM_STR);
            $stmt->bindValue(':income_comment', $this->income_comment, PDO::PARAM_STR);
            $stmt->bindValue(':amount', $this->amount, PDO::PARAM_STR);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Remove income
     * 
     * @return void
     */
    public static function removeTableRowAjax() {
        $sql = 'DELETE FROM incomes
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);

        return $stmt->execute();
    }
}