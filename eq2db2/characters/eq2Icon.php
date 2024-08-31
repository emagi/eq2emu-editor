<?php
	if (isset($_GET['id']))
	{
		$id = $_GET['id'];
		$icon_width = 42;
		$icon_height = 42;

		$page = (int)($id / 36) + 1;
		if (isset($_GET['type']) && $_GET['type'] == "spells")
			$image_path = "../images/icons/icon_ss" . $page . ".png";
		else
			$image_path = "../images/icons/icon_is" . $page . ".png";
	
		$offset = $id % 36;
		$row = (int)($offset / 6);
		$column = $offset % 6;

	
		$width_offset = $column * $icon_width;
		$height_offset = $row * $icon_height;

		$img = null;
		$img = @imagecreatefromstring(file_get_contents($image_path));
		if ($img) {
			$tmp_img = imagecreatetruecolor($icon_width, $icon_height);
			imagecopyresampled($tmp_img, $img, 0, 0, $width_offset, $height_offset, $icon_width, $icon_height, $icon_width, $icon_height);
			imagedestroy($img);
			$img = $tmp_img;
		}

		# Display the image
		header("Content-type: image/png");
		imagepng($img);
		imagedestroy($img);
	}
?>