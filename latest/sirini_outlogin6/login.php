<?php
// 이동할 주소 정하기
$boardTargetID = $_GET['id'];
if($boardTargetID) $move = 'board.php?id='.$boardTargetID;
else $move = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
?>
<div id="grLoginForm">
	<form id="login" method="post" action="<?php echo $grboard; ?>/login_ok.php">
	<div>
	<input type="hidden" name="fromPage" value="<?php echo $move; ?>" />
	<input type="hidden" name="boardID" value="<?php echo $boardTargetID; ?>" />
	</div>
	<div class="loginLeft">아이디</div>
	<div class="loginRight"><input type="text" name="id" class="loginInput" /></div>
	<div class="loginClear"></div>
	<div class="loginLeft">비밀번호</div>
	<div class="loginRight"><input type="password" name="password" class="loginInput" /></div>
	<div class="loginClear"></div>
	<div class="loginAlign"><input type="image" src="<?php echo $grboard; ?>/outlogin/<?php echo $theme; ?>/login.gif" /> 
	<a href="#" onclick="window.open('<?php echo $grboard; ?>/join.php?fromPage=outlogin','join','width=650,height=650,menubar=no,scrollbars=no');"><img src="<?php echo $grboard; ?>/outlogin/<?php echo $theme; ?>/join.gif" alt="멤버등록" /></a>
	</div>
	</form>
</div>