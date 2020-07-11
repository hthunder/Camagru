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
        if (isset($_SESSION["id"]) 
        && isset($_SESSION["notifications"]) 
        && isset($_SESSION["username"])) {
            header("Location: /cabinet");
            exit();
        }
        $array = array(
            "title" => "Главная страница",
            "logout" => "",
        );
        print(Template::render($array, ROOT . '/views/site/index.php'));
        return true;
    }
}
