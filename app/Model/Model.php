<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 30.11.17
 * Time: 19:33
 */

namespace App\Model;

use App\Library\Config;

abstract class Model {

    /**
     * @var \PDO
     */
    private static $pdo;

    /**
     * @return \PDO
     */
    public function getPdo() {
        $connection = Config::get('mysql');
        if (self::$pdo === null) {
            self::$pdo = new \PDO('mysql:host=' . $connection['host'] . ';dbname='. $connection['dbname'], $connection['user'], $connection['password']);
        }

        return self::$pdo;
    }

    /**
     * returns the name of the mysql table used for the model
     *
     * @return string
     */
    abstract public function getSource();

    /**
     * returns an array of objects
     *
     * @return array
     */
    public static function all() {
        $model = new static();
        $table = $model->getSource();
        $pdo = $model->getPdo();

        $stmt = $pdo->prepare('SELECT * FROM `' . $table . '`');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_CLASS, get_class($model));
    }

    /**
     * returns an object with the given id or false
     * @param $id
     * @return object
     */
    public static function findById($id) {
        $model = new static();
        $table = $model->getSource();

        $pdo = $model->getPdo();

        if ($id) {
            $stmt = $pdo->prepare('SELECT * FROM `' . $table . '` WHERE id = ? LIMIT 1');
            $stmt->execute([(int)$id]);
        } else {
            throw new \UnexpectedValueException('you need to pass an id');
        }

        return $stmt->fetchObject(get_class($model));
    }

    public static function find(array $options) {
        $model = new static();
        $table = $model->getSource();

        $pdo = $model->getPdo();

        if (!isset($options['criteria'])) {
            throw new \UnexpectedValueException('you need to specify the criteria');
        }

        $stmt = $pdo->prepare('SELECT * FROM `' . $table . '` WHERE ' . $options['criteria']);
        $stmt->execute($options['bind']);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, get_class($model));
    }

    /**
     * saves an object. if the object wasn't saved before it fills the id of the object with the mysql row id
     */
    public function save() {
        $table = $this->getSource();
        $pdo = $this->getPdo();
        if (method_exists($this, 'beforeSave')) {
            var_dump('test');

            $this->beforeSave();
        }
        $fields = [];
        foreach ($this as $name => $val) {
            if ($val === null) {
                $fields[] = "`$name`=null";
            } elseif (is_int($val)) {
                $fields[] = "`$name`=" . $val;
            } else {
                $fields[] = "`$name`=" . $pdo->quote($val);
            }
        }

        if ($this->id === null) {

            if (!$pdo->exec('INSERT INTO `' . $table . '` SET ' . implode(',', $fields))) {
                throw new \RuntimeException('Could not create ' . get_class($this) . ': ' . $pdo->errorInfo()[2]);
            }
            // fill the id
            $this->id = $pdo->lastInsertId();
        } else {
            // update entry
            if ($pdo->exec('UPDATE `' . $table . '` SET ' . implode(',', $fields) . ' WHERE `id` = ' . ((int)$this->id)) === FALSE) {
                throw new \RuntimeException('Could not update ' . get_class($this) . ': ' . $pdo->errorInfo()[2]);
            }
        }
    }

    /**
     * delete the record
     */
    public function delete() {
        $table = $this->getSource();
        $pdo = $this->getPdo();
        if ($this->id) {
            $stmt = $pdo->prepare('DELETE FROM `' . $table . '` WHERE id = ? ');
            $stmt->execute([$this->id]);
        } else {
            throw new \UnexpectedValueException('this model has no id');
        }
    }
}
