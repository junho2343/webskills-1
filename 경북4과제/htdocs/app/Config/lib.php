<?php

	function back(){
		echo "<script>history.back()</script>";
		exit;
	}
	function location($location){
		echo "<script>location.href='$location'</script>";
		exit;
	}
	function alert(){
		if(isset($_SESSION['msg'])){
			echo "<script>alert('{$_SESSION['msg']}')</script>";
			unset($_SESSION['msg']);
		}
	}
	function isMember(){
		if(isset($_SESSION['member'])){
			return $_SESSION['member'];
		}
		return false;
	}

	function convertDate($date){
		$date = str_replace("년 ", "-", $date);
		$date = str_replace("월 ", "-", $date);
		$date = str_replace("일", "", $date);
		return $date;
	}

	function convertDate2($date){
		$d = explode("-",$date);
		return "{$d[0]}년 {$d[1]}월 {$d[2]}일";
	}