<?php
// 쪽지알림 레이어 표시여부
$msg_poupop = "1"; // 설정할경우 1, 설정하지 않을경우 빈값

// 이동할 주소 정하기
$boardTargetID = $_GET['id'];
if($boardTargetID) $move = 'board.php?id='.$boardTargetID;
else $move = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];

// 실명 가져오기
$realname = @mysql_fetch_array(mysql_query('select realname from '.$dbFIX.'member_list where no = '.$_SESSION['no']));
?>
<div id="grLoginForm"><div id="grLoginBox">

	<div class="loginBox">
		<span class="loginLeft">&nbsp;아이디</span>
		<span class="loginRight"><?php echo $login['id']; ?> <a href="<?php echo $grboard; ?>/view_memo.php" onclick="window.open(this.href, '_blank', 'width=600,height=650,menubar=no,scrollbars=yes'); return false" style="font-size: 10px" title="클릭하시면 쪽지함을 열어봅니다."><?php if($ismemo) { ?><span style="color: red; font-weight: bold;">[m]</span><?php } else { ?>[m]<?php } ?></a></span>
	</div>
	<div class="loginBox">
		<span class="loginLeft">성 &nbsp; 함</span>
		<span class="loginRight"><?php echo stripslashes($realname['realname']); ?>
	<?php if($_SESSION['no'] == 1) { ?>&nbsp;&nbsp;<a href="<?php echo $grboard; ?>/admin.php" style="color: #ff0000">*</a><?php } ?></span>
	</div>

	<div class="loginAlign">
		<a href="#" onclick="window.open('<?php echo $grboard; ?>/info.php','my_info','width=650,height=600,menubar=no,scrollbars=yes');"><img src="<?php echo $grboard; ?>/outlogin/<?php echo $theme; ?>/modify.gif" alt="정보수정" /></a>
		<a href="#" onclick="location.href='<?php echo $grboard; ?>/logout.php?page=<?php echo $move; ?>'"><img src="<?php echo $grboard; ?>/outlogin/<?php echo $theme; ?>/logout.gif" alt="로그아웃" /></a>
	</div>

</div></div>