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
        if (User::isLogged()) {
            header("Location: /cabinet");
            exit();
        }
        $array = array(
            "title" => "Главная страница",
            "transparency" => "header_bg_transparent",
        );
        $array["burger"] = Template::prerender(ROOT . "/views/layouts/_burger/_burger-unauthorized.php");
        print(Template::render($array, ROOT . '/views/site/index.php'));
        return true;
    }
}
