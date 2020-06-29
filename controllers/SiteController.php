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
        if (User::checkLogged()) {
            header("Location: /cabinet");
            exit();
        }
        $array = array(
            "title" => "Главная страница",
        );
        print(Template::render($array, ROOT . '/views/site/index.php'));
        return true;
    }
}
