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
			"checked" => isset($_SESSION["notifications"]) && $_SESSION["notifications"] == 1 ? "checked" : "",
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
			$photo_src = explode('.', $photo)[0];
			$file_name = $photo;
			$str = "<a class='photo__grid-link' href='/photo/page/{photo_userid}/{photo_src}'>
					    <img class='photo__grid-item' src='/public/images/gallery/{photo_userid}/{file_name}'>
					</a>";
			$str = str_replace("{photo_userid}", $_SESSION["user"], $str);
			$str = str_replace("{photo_src}", $photo_src, $str);
            $str = str_replace("{file_name}", $file_name, $str);
			$array["lastPhotos"] .= $str;
		}
		print(Template::render($array, ROOT . '/views/photo/make.php'));
        return true;
    }

	public function actionGallery() {
		$array = array(
			"title" => "Галерея",
			"gallery__grid" => "",
			"min_id" => null,
			"checked" => isset($_SESSION["notifications"]) && $_SESSION["notifications"] == 1 ? "checked" : "", 
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
			"fullName" => "",
			"likeIcon" => "",
			"comments" => "",
			"showMore" => "",
			"checked" => isset($_SESSION["notifications"]) && $_SESSION["notifications"] == 1 ? "checked" : "", 
			"deletePhoto" => "",
		);
		$guestId = $_SESSION['user'];
		$likesNumber = Photo::getLikesNumber($name);
		$array["likesNumber"] = $likesNumber;
		$deletePhoto = file_get_contents(ROOT . "/views/layouts/_delete-photo.php");
		if ($deletePhoto && $guestId == $hostId)
			$array["deletePhoto"] = $deletePhoto;
		$temp = Photo::getPhotoByName($name);
		$comments = Photo::getComments($temp["id"]);
		$array["fullName"] = $temp["photo_src"];
		if (!isset($temp["photo_src"]) || !file_exists(ROOT . "/public/images/gallery/$hostId/" . $temp["photo_src"])) {
			header("Location: /photo/gallery");
			exit();
		}
		$photoId = $temp['id'];
		$array["photoId"] = $photoId;
		$isLiked = Like::isLiked($photoId, $guestId);

		if($isLiked != null && $isLiked == 1) {
			$str = "<img class='page__likes-icon' src='/public/images/icons/likePushed.svg' alt='лайк' data-photo-id='{photoId}'>";
			$str = str_replace("{photoId}", $array["photoId"], $str);
		} else {
			$str = "<img class='page__likes-icon' src='/public/images/icons/like.svg' alt='лайк' data-photo-id='{photoId}'>";
			$str = str_replace("{photoId}", $array["photoId"], $str);
		}
		$array["likeIcon"] .= $str;

		$counter = 0;
		foreach($comments as $comment) {
			$cmt = $counter < 5 ? "<article class='commentary'>" : "<article class='commentary commentary_hidden'>";
			$cmt .= "<p class='commentary__text'>"
				. "<span class='commentary__author'>{commentAuthor}: </span>"
				. "{commentText}<button class='commentary__delete-btn' data-comment-id='{commentId}'>x</button>"
				. "</p>"
				. "</article>";
			$cmt = str_replace("{commentText}", htmlspecialchars($comment["text"]), $cmt);
			$cmt = str_replace("{commentAuthor}", htmlspecialchars($comment["username"]), $cmt);
			$cmt = str_replace("{commentId}", $comment["id"], $cmt);
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
				$user = Common::getRowsBy("id", $array["photoId"], "photos")->fetch();
				if ($user["user_id"] == $_SESSION["user"]) {
					Photo::deletePhoto($array["photoId"], $user["user_id"], $user["photo_src"]);
				}
			}
		}
	}
}