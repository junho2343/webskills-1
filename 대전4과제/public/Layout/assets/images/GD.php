<?php
				header("Content-type: image/jpeg");

				$map = imagecreatefromjpeg("map.jpg");
				$red = imagecreatefrompng("red_map_marker.png");
				$blue = imagecreatefrompng("blue_map_marker.png");
				$pink = imagecreatefrompng("pink_map_marker.png");
				

				$x = -100;	
				$y = -100;	
	
				if(isset($_GET["x"])){
					$x = $_GET["x"]-10;
					$y = $_GET["y"]-30;
				}

				imagecopy($map, $red, 697, 315, 0, 0, 20, 31);
				imagecopy($map, $blue, 539, 225, 0, 0, 20, 31);imagecopy($map, $blue, 354, 259, 0, 0, 20, 31);	
				imagecopy($map, $pink, $x,$y, 0, 0, 20, 31);

				imagejpeg($map);
				imagedestroy($map);
			?>