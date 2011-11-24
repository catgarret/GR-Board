<?php if(!defined('__GRBOARD__')) exit(); if($articleNo) echo '<div style="height: 30px"></div>'; include $theme.'/lib/list_lib.php'; ?>
<form id="list" method="post" action="<?php echo $grboard; ?>/list_adjust.php"> <div> <input type="hidden" name="id" value="<?php echo $id; ?>" /> <input type="hidden" name="articleNo" value="<?php echo $articleNo; ?>" /> </div>
<table id="grListTable"> <caption><?php echo $board_name[name]; ?> 목록 - <?php echo $page; ?> 페이지</caption> <colgroup> <col class="no" /> <?php if($isAdmin): ?><col class="checkBox" /><?php endif; ?> <?php if($isCategory): ?><col class="category" /><?php endif; ?> <col class="subject" /> <col class="name" /> <col class="date" /> <col class="hit" /> </colgroup>
<!-- 머리목록 --> <thead> <tr> <th class="no"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=no&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>" title="목록을 번호 순서대로 정렬합니다."><?php if($sortList=='no') echo'<strong>번호</strong>'; else echo '번호'; ?></a></th> <?php if($isAdmin): ?><th class="checkBox"><a href="#" onclick="selectAll();" title="현재 목록에 있는 모든 게시물들을 선택합니다.">선택</a></th><?php endif; ?> <?php if($isCategory): ?> <th class="category"> <select name="chooseCategory" onchange="setCategory(this.value)" title="분류"> <option value="">분류</option> <?php showCategoryComboBox(); ?> </select> </th> <?php endif; ?> <th class="subject"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=subject&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>" title="목록을 제목 순서대로 정렬합니다."><?php if($sortList=='subject') echo'<strong>제목</strong>'; else echo '제목'; ?></a></th> <th class="name"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=name&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>" title="목록을 글쓴이 순서대로 정렬합니다."><?php if($sortList=='name') echo'<strong>글쓴이</strong>'; else echo '글쓴이'; ?></a></th> <th class="date"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=signdate&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>" title="목록을 등록한 시간 순서대로 정렬합니다."><?php if($sortList=='signdate') echo'<strong>작성시간</strong>'; else echo '작성시간'; ?></a></th> <th class="hit"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;sortList=hit&amp;sortBy=<?php echo ($sortBy=='desc')?'asc':'desc'; ?>&amp;page=<?php echo $page; ?>" title="목록을 조회수 순서대로 정렬합니다."><?php if($sortList=='hit') echo'<strong>조회수</strong>'; else echo '조회수'; ?></a></th> </tr> </thead> <!-- #머리목록 -->
<!-- 게시물 목록 --> <tbody>
<?php while($notice = setNoticeData($GR->fetch($getNotice))): /* 공지글 반복 시작 */ ?> <tr class="noticeArticle"> <td class="no"><span class="spIcon icoNotice">공지</span></td> <?php if($isAdmin): ?><td class="checkBox"><input type="checkbox" name="box[]" value="<?php echo $notice['no']; ?>" /></td><?php endif; ?> <?php if($isCategory): ?><td class="category"><span class="cutString"><?php echo $notice['category']; if(!$notice['category']) echo '<span class="noCategory">분류없음</span>'; ?></span></td><?php endif; ?> <td class="subject" colspan="4"> <span class="tx"><a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;articleNo=<?php echo $notice['no']; ?>&amp;page=<?php echo $page; ?>" class="cutString" ><strong><?php echo $notice['subject']; ?></strong></a></span> </td> </tr> <?php endwhile; /* 공지글 반복 종료 */ ?>

<?php while($list = setArticleData($GR->fetch($getList))): /* 일반글 반복 시작 */ ?> <tr class="normalArticle"> <td class="no"><?php echo $number; ?></td> <?php if($isAdmin): ?><td class="checkBox"><input type="checkbox" name="box[]" value="<?php echo $list['no']; ?>" /></td><?php endif; ?> <?php if($isCategory): ?> <td class="category"> <a href="<?php echo $grboard; ?>/board.php?id=<?php echo $id; ?>&amp;clickCategory=<?php echo urlencode($list['category']); ?>"  class="cutString"><?php echo $list['category']; if(!$notice['category']) echo '<span class="noCategory">분류없음</span>'; ?></a> </td> <?php endif; ?> <td class="subject">	<span class="tx"><a href="<?php echo $list['link']; ?>" class="cutString" ><?php echo $list['subject']; ?></a> <?php if($list['comment_count']): ?> <span class="comment">[<?php echo $list['comment_count']; ?>]</span><?php endif; ?> <?php if($list['is_secret']) { ?><span class="spIcon is_secret">비밀글</span><?php } ?> <?php if($list['hit'] > 300): ?><span class="spIcon is_hit">HIT</span><?php endif; ?></span> </td> <td class="name"> <span class="stringCut" onclick="getMember(<?php echo (($list['member_key'])?$list['member_key']:0).','.(($_SESSION['no'])?$_SESSION['no']:0); ?>, event);"><?php echo $list['name']; ?></span> </td> <?php $week = array(" 일요일", " 월요일", " 화요일", " 수요일", " 목요일", " 금요일", " 토요일"); $s = $week[date('w', $list['signdate'])]; ?> <td class="date"><time datetime="<?php echo date('c', $list['signdate']); ?>" title="<?php echo date('Y년m월d일', $list['signdate']); echo $s; ?>  <?php echo date('H시i분s초', $list['signdate']); ?>에 등록됨."><?php echo diffDate(date('Y-m-d H:i:s', $list['signdate']),date('Y-m-d H:i:s')); ?></time></td> <td class="no"><?php echo $list['hit']; ?></td> </tr> <?php $number--; endwhile; /* 일반글 반복 종료 */ ?> </tbody> <!-- #게시물 목록 --> </table> </form> <div id="viewMemberInfo" onmouseout="showOff();" style="display: none;"></div>