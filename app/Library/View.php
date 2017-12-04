<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 03.12.17
 * Time: 16:21
 */

namespace App\Library;


/**
 * Class View
 * @package App\Library
 */
class View {

    /**
     * @var array
     */
    private $globals = [];

    /**
     * View constructor.
     */
    public function __construct() {

    }

    public function e($value){
        echo htmlspecialchars($value);
    }

    /**
     * @param $key
     * @param null $value
     */
    public function globalVars($key, $value = null) {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->globalVars($k, $v);
            }
        } else {
            $this->globals[$key] = $value;
        }
    }

    /**
     * @param $template
     * @param array $variables
     * @param bool $return
     * @param bool $header
     * @param bool $footer
     * @return $this|bool|string
     */
    public function render($template, $variables = [], $return = false, $header= true, $footer = true) {
        $template = VIEW_DIR . DS . $template . '.phtml';
        if (!file_exists($template)) {
            return false;
        }
        foreach ($variables as $key => $variable) {
            $$key = $variable;
        }
        foreach ($this->globals as $key => $value) {
            $$key = $value;
        }
        ob_start();
        if($header){
            require_once VIEW_DIR . DS . 'partials'. DS . 'header.phtml';
        }
        require_once $template;
        if($footer){
            require_once VIEW_DIR . DS . 'partials'. DS . 'footer.phtml';
        }

        $template = ob_get_contents();
        ob_end_clean();
        if ($return == false) {
            echo $template;
        } else {
            return $template;
        }

        return $this;
    }
}
