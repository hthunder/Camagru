<?php

class Template
{
    public static function render(array $params, $main_template) {
        ob_start();
        include($main_template);
        $file = ob_get_contents();
        ob_end_clean();
        foreach($params as $key => $value) {
            $template = "{" . $key . "}";
            $file = str_replace($template, $value, $file);
        }
        return $file;
    }
}