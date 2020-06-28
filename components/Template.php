<?php

class Template
{
    public static function render(array $params, $file) {
        foreach($params as $key => $value) {
            $template = '{' . $key . '}';
            $file = str_replace($template, $value, $file);
        }
        return $file;
    }
}