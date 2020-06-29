<?php

/**
 * Контроллер CartController
 */
class SiteController
{

    /**
     * Action for a main page
     */
    public function actionIndex()
    {
        $array = array(
            "title" => "Главная страница",
        );
        print(Template::render($array, ROOT . '/views/site/index.php'));
        return true;
    }
}
