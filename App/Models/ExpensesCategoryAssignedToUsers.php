<?php

namespace App\Models;

use PDO;
use \App\Config;
use \Core\View;

/**
 * expenses model
 *
 * PHP version 8.2
 */
class ExpensesCategoryAssignedToUsers extends \Core\Model
{
    /**
     * expenses_category_assigned_to_users table id
     * 
     * @var string
     */
    public $id;

    /**
     * expenses_category_assigned_to_users table user_id
     * 
     * @var string
     */
    public $user_id;

    /**
     * expenses_category_assigned_to_users table name
     * 
     * @var string
     */
    public $name;

    /**
     * expenses_category_assigned_to_users table limit_value
     * 
     * @var float
     */
    public $limit_value;

    public static function getCategoriesAssignedToUser($user_id)
    {
        $sql = 'SELECT * FROM expenses_category_assigned_to_users
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
        $sql = 'SELECT name FROM expenses_category_assigned_to_users
                WHERE id = :id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetch();

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
     * @return mixed ExpensesCategoryAssignedToUsers object if found, false otherwise
     */
    public static function findCategoryByName($name, $user_id)
    {
        $sql = 'SELECT * 
                FROM expenses_category_assigned_to_users
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
        $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name)
                SELECT :user_id, name FROM expenses_category_default';

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
    public static function addCategory($user_id, $name, $limit_value)
    {
        $sql = 'INSERT INTO expenses_category_assigned_to_users (user_id, name, limit_value)
                VALUES (:user_id, :name, :limit_value)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':limit_value', $limit_value, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * update category name
     * 
     * @return void
     */
    public static function updateCategory($id, $name, $limit_value)
    {
        if( isset($name) ) {
            $sql = 'UPDATE expenses_category_assigned_to_users
            SET name = :name,
            limit_value = :limit_value
            WHERE id = :id';
        } else {
            $sql = 'UPDATE expenses_category_assigned_to_users
            SET limit_value = :limit_value
            WHERE id = :id';
        }

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if (isset($name)) {
            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit_value', $limit_value, PDO::PARAM_STR);

        $stmt->execute();
    }

    /**
     * remove category
     * 
     * @return void
     */
    public static function removeCategory($id)
    {
        $sql = 'DELETE FROM expenses_category_assigned_to_users
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
        $sql = 'SELECT eu.name AS category_name, COUNT(e.id) AS transactions
                FROM expenses AS e, expenses_category_assigned_to_users AS eu
                WHERE e.user_id = :user_id
                AND e.expense_category_assigned_to_user_id = :category_id
                AND e.expense_category_assigned_to_user_id = eu.id
                GROUP BY eu.name';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function getLimit($user_id, $category_id) {
        $sql = 'SELECT limit_value
                FROM expenses_category_assigned_to_users
                WHERE e.user_id = :user_id
                AND e.expense_category_assigned_to_user_id = :category_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute();

        return $stmt->fetch();
    }
}