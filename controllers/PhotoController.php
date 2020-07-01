<?php

/**
 * Контроллер PhotoController
 */
class PhotoController
{
	public function actionCreate()
	{
		User::checkLogged();
		if (isset($_POST['hidden'])) {
			$img = $_POST['hidden'];
			$info = $_POST['info'];
			$info = json_decode($info);
			$id = $_SESSION['user'];
			$path = ROOT . '/public/images/gallery/' . $id;
			if (!file_exists($path)) {
				mkdir($path);	
			}
			Photo::createPhoto($img, $info, $id);
			header("Location: /photo/make");
			return true;
		}
	}
	
	public function actionMake()
    {
		User::checkLogged();
		$array = array(
			"title" => "Сделать фото",
			"masks" => "",
			"lastPhotos" => "",
			"errors" => !empty($_SESSION["errors"]) ? $_SESSION["errors"] : "",
		);
		if (isset($_SESSION["errors"]))
			unset($_SESSION["errors"]);
		$id = $_SESSION['user'];
		$masks = Photo::getMasks();
		$lastPhotos = Photo::getLastPhotos($id);
		foreach ($masks as $mask) {
			if (!($mask == '.' || $mask == '..')) {
				$array["masks"] .= Template::render(array("mask" => $mask), ROOT . '/views/layouts/_masks.php');
			}
		}
		foreach ($lastPhotos as $photo) {
			$array["lastPhotos"] .= "<div class='chtoto-tam'>
			<img class='photo__grid-item' src='/public/images/gallery/$id/$photo'></div>";
		}
		print(Template::render($array, ROOT . '/views/photo/make.php'));
        return true;
    }

	public function actionGallery() {
		$array = array(
			"title" => "Галерея",
			"gallery__grid" => "",
			"min_id" => null,
		);
		$photos = Photo::getAllPhotos();
		foreach($photos as $photo) {
			if ($array["min_id"] === NULL || $photo["id"] < $array["min_id"])
				$array["min_id"] = $photo["id"];
			
			$photo_src = explode('.', $photo['photo_src'])[0];
			$file_name = $photo_src . ".jpg";
			$str = "<a class='gallery__grid-link' href='/photo/page/{photo_userid}/{photo_src}'>
						<img class='gallery__grid-item' src='/public/images/gallery/{photo_userid}/{file_name}'>
					</a>";
			$str = str_replace("{photo_userid}", $photo["user_id"], $str);
			$str = str_replace("{photo_src}", $photo_src, $str);
			$str = str_replace("{file_name}", $file_name, $str);
			$array["gallery__grid"] .= $str;
		}
		print(Template::render($array, ROOT . '/views/photo/gallery.php'));
		return true;
	}

	public function actionShowMore() {
		User::checkLogged();
		if (isset($_POST['id'])) {
			$minId = $_POST['id'];
			$photos = Photo::showMore($minId);
			header('Content-Type: application/json');
			echo json_encode($photos);
			return true;	
		}
		return false;
		header("Location: /");
	}

	public function actionPage($hostId, $name) {
		User::checkLogged();
		$array = array(
			"title" => "Страница фотографии",
			"hostId" => !empty($hostId) ? $hostId : "",
			"name" => !empty($name) ? $name : "",
			"likeIcon" => "",
			"comments" => "",
			"showMore" => "",
		);
		$comments = Photo::getComments($name);
		$guestId = $_SESSION['user'];
		$likesNumber = Photo::getLikesNumber($name);
		$array["likesNumber"] = $likesNumber;
		$photoId = Photo::getIdByName($name)['id'];
		$array["photoId"] = $photoId;
		$isLiked = Like::isLiked($photoId, $guestId);

		if($isLiked != null && $isLiked == 1) {
			$str = "<img class='page__likes-icon' src='/public/images/icons/likePushed.svg' alt='лайк' data-photo-name='{name}'>";
			$str = str_replace("{name}", $array["name"], $str);
		} else {
			$str = "<img class='page__likes-icon' src='/public/images/icons/like.svg' alt='лайк' data-photo-name='{name}'>";
			$str = str_replace("{name}", $array["name"], $str);
		}
		$array["likeIcon"] .= $str;

		$counter = 0;
		foreach($comments as $comment) {
			if ($counter < 5) {
				$cmt = "<article class='commentary'>"	
										. "<p class='commentary__text'>"
											. "<span class='commentary__author'>{commentAuthor}: </span>"
											. "{commentText}"
										. "</p>"
									. "</article>";
			} else {
				$cmt = "<article class='commentary commentary_hidden'>"
										. "<p class='commentary__text'>"
											. "<span class='commentary__author'>{commentAuthor}: </span>"
											. "{commentText}"
										. "</p>"
									. "</article>";
			}
			$cmt = str_replace("{commentText}", $comment["text"], $cmt);
			$cmt = str_replace("{commentAuthor}", $comment["username"], $cmt);
			$array["comments"] .= $cmt;
			$counter++; 
		}
		if ($counter > 5) {
			$array["showMore"] .= "<input class='commentaries__show-more' type='button' value='Показать больше' onclick='showMoreComments();'>";
		}

		print(Template::render($array, ROOT . '/views/photo/page.php'));
		return true;
	}

	public function actionDelete() {
		User::checkLogged();
		$array = array(
			"photoId" => !empty($_POST["photoId"]) ? $_POST["photoId"] : "",
		);
		if (isset($_POST["delete"])) {
			if ($array["photoId"]) {
				$user = Photo::getRowBy("id", $array["photoId"], "photos");
				if ($user["user_id"] == $_SESSION["user"]) {
					Photo::deletePhoto($array["photoId"], $user["user_id"], $user["photo_src"]);
				}
			}
		}
	}

	// /**
    //  * A changeInfo action lets to update a user login and email
    //  */
    // public function actionChangeInfo() {
    //     User::checkLogged();
    //     $array = array(
    //         "username" => !empty($_POST["username"]) ? substr($_POST["username"], 0, 30) : "",
    //         "email" => !empty($_POST["email"]) ? substr($_POST["email"], 0, 30) : "",
    //         "password" => !empty($_POST["password"]) ? $_POST["password"] : "",
    //         "errors" => "",
    //     );
    //     if (isset($_POST["changeInfo"])) {
    //         if ($array["username"] && $array["email"] && $array["password"]) {
    //             $array["errors"] .= User::changeInfoValidation($array);
    //             if ($array["errors"] === "") {
    //                 $user = User::getUserBy('id', $_SESSION["user"]);
    //                 if ($user && password_verify($array["password"], $user["password"])) {
    //                     $newArray = array(
    //                         "email" => $array["email"],
    //                         "username" => $array["username"],
    //                     );
    //                     if (!User::updateUserData($newArray, $_SESSION["user"]))
    //                         $array["errors"] .= "Что-то пошло не так</br>";
    //                 } else {
    //                    $array["errors"] .= "Введен неверный пароль</br>"; 
    //                 }
    //             }
    //         } else {
    //             $array["errors"] .= "Не все поля заполнены</br>";
    //         }
    //     }
    //     $_SESSION["editErrors"] = $array["errors"];
    //     header("Location: /cabinet");
    //     exit();
    // }


}