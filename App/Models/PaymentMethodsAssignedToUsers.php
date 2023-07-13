<?php

namespace App\Models;

use PDO;
use \App\Config;
use \Core\View;

/**
 * payment_methods_assigned_to_users model
 *
 * PHP version 8.2
 */
class PaymentMethodsAssignedToUsers extends \Core\Model
{
    /**
     * payment_methods_assigned_to_users table id
     * 
     * @var string
     */
    public $id;

    /**
     * payment_methods_assigned_to_users table user_id
     * 
     * @var string
     */
    public $user_id;

    /**
     * payment_methods_assigned_to_users table name
     * 
     * @var string
     */
    public $name;
    
    public static function getCategoriesAssignedToUser($user_id)
    {
        $sql = 'SELECT * FROM payment_methods_assigned_to_users
                WHERE user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetchAll();

    }

    public static function getCategoryName($id)
    {
        $sql = 'SELECT name FROM payment_methods_assigned_to_users
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetchColumn();

    }

    /**
     * See if a category already exists with the specified name
     *
     * @param string $name name address to search for
     * @param string $ignore_id Return false anyway if the record found has this ID
     *
     * @return boolean  True if a record already exists with the specified name, false otherwise
     */
    public static function categoryExists($name, $user_id, $ignore_id = null)
    {
        $category = static::findCategoryByName($name, $user_id);

        if ($category) {
            if ($category->id != $ignore_id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Find a category by its name
     *
     * @param string $name category name to search for
     *
     * @return mixed PaymentMethodsAssignedToUsers object if found, false otherwise
     */
    public static function findCategoryByName($name, $user_id)
    {
        $sql = 'SELECT *
                FROM payment_methods_assigned_to_users
                WHERE name = :name AND user_id = :user_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function fillCategoriesAssignedToUserWithDefault($user_id)
    {
        $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name)
                SELECT :user_id, name FROM payment_methods_default';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

        $stmt->execute();

    }

    /**
     * add new category
     * 
     * @return void
     */
    public static function addCategory($user_id, $name)
    {
        $sql = 'INSERT INTO payment_methods_assigned_to_users (user_id, name)
                VALUES (:user_id, :name)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * update category name
     * 
     * @return void
     */
    public static function updateCategory($id, $name)
    {
        $sql = 'UPDATE payment_methods_assigned_to_users
                SET name = :name
                WHERE id = :id'; 

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * remove category
     * 
     * @return void
     */
    public static function removeCategory($id)
    {
        $sql = 'DELETE FROM payment_methods_assigned_to_users
                WHERE id = :id'; 

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
    }

    /**
     * check if any transaction exists for this category
     * 
     * @param int user_id
     * @param int category_id to look for
     * 
     * @return mixed
     */
    public static function transactionsSumForSelectedCategory($user_id, $category_id)
    {
        $sql = 'SELECT pu.name AS category_name, COUNT(e.id) AS transactions
                FROM expenses AS e, payment_methods_assigned_to_users AS pu
                WHERE e.user_id = :user_id
                AND e.payment_method_assigned_to_user_id = :category_id
                AND e.payment_method_assigned_to_user_id = pu.id
                GROUP BY pu.name';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetch();
    }
}