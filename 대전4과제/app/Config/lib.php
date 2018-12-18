<?php

	function back(){
		echo "<script>history.back();</script>";
		exit;
	}

	function location($location){
		echo "<script>location.href='{$location}';</script>";
		exit;
	}

	function alert($msg){
		echo "<script>alert('{$msg}')</script>";

	}

	function isMember(){
		return isset($_SESSION['member']) ? $_SESSION['member'] : false;
	}

	function idStart($id){
		$arr = str_split($id);
		$rid = "";
		for ($i=0; $i < count($arr); $i++) { 
			if($i < 3)
				$rid .= $arr[$i];
			else
				$rid .= "*";
		}

		return $rid;
	}

	

	function GD($shopList){

		$mX = isMember()['m_x']-10;
		$mY = isMember()['m_y']-30;

		$file = fopen(_PUBLIC."/Layout/assets/images/GD.php", "w");
		$shop = "";

		foreach ($shopList as $key => $value) {
			$shop .= 'imagecopy($map, $blue, '.($value['m_x']-10).', '.($value['m_y']-30).', 0, 0, 20, 31);';
		}

		fwrite($file,'<?php
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

				imagecopy($map, $red, '.$mX.', '.$mY.', 0, 0, 20, 31);
				'.$shop.'	
				imagecopy($map, $pink, $x,$y, 0, 0, 20, 31);

				imagejpeg($map);
				imagedestroy($map);
			?>');
		fclose($file);
	}


