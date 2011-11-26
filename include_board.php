<?php
// 보안처리 @sirini
$_GET['grboard'] = $_POST['grboard'] = $_REQUEST['grboard'] = false;
// 보안처리 @sirini
// FI와 LFI 취약점 @김동현(Ste@lth) in BlackFalcon
if ($_GET['grboard'] || $_POST['grboard']||$_COOKIE['grboard']||$_OPTION['grboard']||$_HEAD['grboard']||$_TRACE['grboard']) {
    unset($_GET['grboard']);
    unset($_POST['grboard']);
    unset($_COOKIE['grboard']);
    unset($_OPTION['grboard']);
    unset($_HEAD['grboard']);
    unset($_TRACE['grboard']);
	unset($grboard);
}
if(!$grboard) exit();

// 아웃로긴 함수 정의 @sirini
function outlogin($theme) {
	global $grboard, $dbFIX, $GR;
	$path = $grboard . '/outlogin/'.$theme;
	$isOutlogin = 1; // 아웃로그인 사용여부 @이동규
	if(!is_dir($path)) die('GR Board 내의 outlogin 폴더 안에 지정한 '.$theme.' 스킨이 존재하지 않습니다. (path='.$path.')');
	if($_SESSION['no']) 	{
		$sessionNo = $_SESSION['no'];
		$getInfo = $GR->query('select id, nickname, make_time, level, point from '.$dbFIX.'member_list where no = '.$sessionNo);
		$login = $GR->fetch($getInfo);
		include $path.'/logged.php';
	} else {
		$sessionNo = 0;
		if($_GET['boardID']) $_GET['id'] = $_GET['boardID'];
		include $path.'/login.php';
	}
}

// 문자열 자르기 @sirini
function cutString($str, $size=0) {
	if($size<=0) return $str;
	if(function_exists('mb_strcut')) return mb_strcut($str, 0, $size, 'utf-8');
	$result = substr($str, 0, $size);
	preg_match('/^([\\x00-\\x7e]|.{3})*/', $result, $string);
	return $string[0];
}

// 최근게시물 함수 정의 @sirini
function latest($theme, $id, $listNum=5, $cutSize=0, $getContent=0, $cutContentSize=0, $dateFormat='Y.m.d', $latestTitle='최근게시물', $orderBy='no', $desc='desc') {
	global $dbFIX, $GR, $grboard;
	$path = $grboard . '/latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if($getContent) $addQue = ', content';	else $addQue = '';
	$getData = $GR->query('select no, name, signdate, comment_count, category, subject'.$addQue.' from '.$dbFIX.'bbs_'.$id.' order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 통합 최근게시물 함수 정의 @sirini
function total_article_latest($theme, $listNum=5, $cutSize=0, $dateFormat='Y.m.d', $latestTitle='통합 최근게시물', $isSecret=false, $orderBy='no', $desc='desc', $boardList='') {
	global $dbFIX, $GR, $grboard;
	$path = $grboard . '/latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if(!$isSecret) $addQ = 'where is_secret != 1 '; else $addQ = 'where is_secret != 99 ';
	if($boardList) $addQ .= "and id = '".str_replace('|', "' or id = '", $boardList)."' ";
	$getData = $GR->query('select * from '.$dbFIX.'total_article '.$addQ.'order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 통합 최근코멘트 함수 정의 @sirini
function total_comment_latest($theme, $listNum=5, $cutSize=0, $dateFormat='Y.m.d', $latestTitle='통합 최근코멘트', $isSecret=false, $orderBy='no', $desc='desc', $boardList='') {
	global $dbFIX, $GR, $grboard;
	$path = $grboard . '/latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if(!$isSecret) $addQ = 'where is_secret != 1 '; else $addQ = 'where is_secret != 99 ';
	if($boardList) $addQ .= "and id = '".str_replace('|', "' or id = '", $boardList)."' ";
	$getData = $GR->query('select * from '.$dbFIX.'total_comment '.$addQ.'order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 설문조사 함수 정의 @sirini
function poll($theme) {
	global $grboard, $dbFIX, $GR;
	$path = $grboard.'/latest/'.$theme;
	if(!is_dir($path)) die('GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.');
	$getSubject = $GR->getArray('select no, subject from '.$dbFIX.'poll_subject where id = \'\' order by no desc limit 1');
	$subject = stripslashes($getSubject['subject']);
	$pollNo = $getSubject['no'];
	$getOptions = $GR->query('select no, title from '.$dbFIX.'poll_option where poll_no = '.$pollNo.' order by no asc');
	include $path.'/poll.php';
}

// 통합검색폼 함수 정의 @sirini
function total_search($theme, $listNum=10) {
	global $grboard, $dbFIX, $GR;
	$path = $grboard.'/latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	include $path.'/list.php';
}

// 통합 태그 구름 함수 정의 @sirini
function total_tag_latest($theme, $listNum=5, $latestTitle='태그 구름', $orderBy='no', $desc='desc', $boardList='') {
	global $grboard, $dbFIX, $GR;
	$path = $grboard.'/latest/'.$theme;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if($boardList) $addQ = "where id = '".str_replace('|', "' or id = '", $boardList)."' ";
	$getData = $GR->query('select * from '.$dbFIX.'tag_list '.$addQ.'order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 현재 접속자 목록 함수 정의 @sirini
function now_connect_list($theme, $listNum=20, $latestTitle='현재 접속자', $orderBy='lastlogin', $desc='desc') {
	global $grboard, $dbFIX, $timeDiff, $GR;
	$path = $grboard.'/latest/'.$theme;
	$_time = time()+$timeDiff;
	if(!is_dir($path)) { echo 'GR Board 내의 latest 폴더 안에 지정한 '.$theme.' 테마가 존재하지 않습니다.'; return; }
	if($_SESSION['no']) $GR->query('update '.$dbFIX.'member_list set lastlogin = \''.$_time.'\' where no = '.$_SESSION['no']);
	$getData = $GR->query('select no, id, nickname, nametag, icon from '.$dbFIX.'member_list where lastlogin > '.($_time-600).' order by '.$orderBy.' '.$desc.' limit '.$listNum);
	include $path.'/list.php';
}

// 게시판 이름 가져오기 정의 @컴센스
function get_bbs_name($id) {
	global $grboard, $dbFIX, $GR;
	$result = $GR->getArray('select name from '.$dbFIX.'board_list where id = \''.$id.'\'');
	return $result['name'];
}
?>