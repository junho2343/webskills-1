<?php
	
	//이전페이지
	function back()
	{
		echo "<script>history.back();</script>";
		exit;
	}


	//페이지 이동
	function location($location)
	{
		echo "<script>location.href='{$location}';</script>";
		exit;
	}


	//알림창
	function alert($msg)
	{
		echo "<script>alert('{$msg}');</script>";
	}


	//멤버 세션 반환
	function isMember()
	{
		return isset($_SESSION['member']) ? $_SESSION['member'] : false;
	}

	//날자 변환
	function cdate($date)
	{
		$date = str_replace("년 ","-",$date);
		$date = str_replace("월 ","-",$date);
		$date = str_replace("일","",$date);
		return $date;
	}

	//날자 변환 2
	function cdate2($date)
	{
		$d = explode("-",$date);
		return "{$d[0]}년 {$d[1]}월 {$d[2]}일";
	}
