<?php
// 기본 클래스를 부르고 시간 측정 시작 @sirini
$preRoute = '../../';
include $preRoute.'class/common.php';
$GR = new COMMON;
$GR->dbConn();
$p = (int)$_GET['p'];

// 설문 추가하기 @sirini
if($_POST['pollSubject']) {
	@extract($_POST);
	$countPollOption = @count($options);
	$pollOption = array();
	$GR->query("insert into {$dbFIX}poll_subject set no = '', subject = '$pollSubject', signdate = '".time()."', comment_num = '0', id = '$id'");
	$insertNo = $GR->getInsertId();
	for($i=0; $i<$countPollOption; $i++) {
		if($options[$i]) {
			$pollOption[$i] = $options[$i];
			$GR->query("insert {$dbFIX}poll_option set no = '', poll_no = '$insertNo', title = '".$pollOption[$i]."', vote = '0', id = '$id'");
		}
	}
	$GR->error('설문을 추가하였습니다. 본문에 추가해 주세요.', 0, 'poll.php?p='.$insertNo);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>설문 추가하기 - GR Board </title>
<link rel="stylesheet" href="poll.css" type="text/css" title="style" />
</head>
<body>

<div id="writePoll">
	<form id="pollInput" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><input type="hidden" name="id" value="<?php echo $id; ?>" /></div>
		<div class="title">설문 추가하기</div>
		<div class="subject"><img src="<?php echo $preRoute; ?>image/admin/admin_poll.gif" alt="설문" style="vertical-align: middle" /> 설문 주제: <input type="text" name="pollSubject" /></div>
		<div class="options">
			<ol id="optionList">
				<li><input type="text" name="options[]" /></li>
				<li><input type="text" name="options[]" /></li>
				<li><input type="text" name="options[]" /></li>
				<li><input type="text" name="options[]" /></li>
				<li><input type="text" name="options[]" /></li>
			</ol>
			<input type="button" value="+ 항목추가" class="s" onclick="document.getElementById('optionList').innerHTML += '<li><input type=\'text\' name=\'options[]\' /></li>';" title="설문 항목을 더 늘립니다." />
			<input type="submit" class="s" value="설문작성완료" />
		</div>
		<div class="help">설문주제를 입력하고(예: 맛있는 야식은?) 하단에 투표를 받을 항목들(예: 1. 통닭, 2. 피자 ...)을 작성합니다. 항목이 더 필요하시면 위의 "+항목추가" 를 클릭하시면 됩니다. 설문을 다 작성하신 후 "설문작성완료" 를 클릭하시면 이 안내문 하단에 "본문 입력 화면에 끌고 가서 넣어 주십시오." 라고 적힌 상자가 나타납니다. 그 것을 메시지 대로 본문에 드래그해서 넣어주시면 됩니다. <span style="color: #ff5500">! 한 번 입력할 시 정확하게 입력해 주세요 !</span></div>

		<?php if($p): ?>
		<img id="pollBox" alt="<?php echo $p; ?>" src="image/insert_poll_msg.gif" style="width: 350px; height: 150px; border: #ccc 1px solid" />
		<?php endif; ?>
	</form>
</div>
</body>
</html>