<?php

class Template
{
    public static function prerender($template) {
        ob_start();
        include($template);
        $prerendered = ob_get_contents();
        ob_end_clean();
        return ($prerendered);
    }

    public static function render(array $params, $main_template) {
        $file = Template::prerender($main_template);
        foreach($params as $key => $value) {
            $template = "{" . $key . "}";
            $file = str_replace($template, $value, $file);
        }
        return $file;
    }
}