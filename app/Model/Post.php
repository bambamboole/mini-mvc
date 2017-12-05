<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 30.11.17
 * Time: 19:59
 */

namespace App\Model;

/**
 * Class Post
 * @package Mvc\Model
 */
class Post extends Model {

    /**
     * @var
     */
    public $id;

    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $content;

    /**
     * @var
     */
    public $created;

    /**
     * @return string
     */
    public function getSource() {
        return 'posts';
    }

    /**
     * @return string
     */
    public function getCreated() {
        $date = new \DateTime($this->created);
        return $date->format("d.m.Y");
    }

    /**
     * @param int $limit
     * @return string
     */
    public function getExcerpt($limit = 100) {
        $words = str_word_count($this->content, 2);
        if (count($words) <= $limit) {
            return $this->content;
        }
        $pos = array_keys($words);
        return substr($this->content, 0, $pos[$limit]) . '...';
    }

    /**
     * set created with before save event
     */
    public function beforeSave() {
        if (!$this->id) {
            $this->created = date('Y-m-d H:i:s');
        }
    }

    /**
     * @param $content
     */
    public function setContent($content) {
        $this->content = trim($content);
    }
}
