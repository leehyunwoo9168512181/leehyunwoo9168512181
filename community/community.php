<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?>
<!DOCTYPE html>    
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>커뮤니티</title>
    <link rel="stylesheet" href="../asset/css/like.css">
    <style>
        #footer {background: #f5f5f5;}
    </style>
<!-- style -->
<?php
    include "../include/style.php" 
    ?>
    <!-- //style -->
</head>
<body>
    <!-- skip -->
    <?php
    include "../include/skip.php"
    ?>
    <!-- //skip -->

    <!-- header -->
    <?php
        include "../include/header.php"    
    ?>
    <!-- //header -->

    <!-- main -->
    <main id="community-contents">
        <h2 class="ir_so">컨텐츠 영역</h2>
        <section id="community-type" class="section center">
            <div class="community-container">
            <div class="category">
                    <ul>
                        <li class ="active"><a href="#">정보공유</a></li>
                    </ul>
                </div>
                <div class="community__inner">
                    <div class="community__cont">
<?php
    if(isset($_GET['page'])){
        $page = (int) $_GET['page'];
    } else {
        $page = 1;
    }
    $keyword = $_GET['searchKeyword'];
    $searchType = $_GET['searchOption'];

    //게시판 불러올 갯수
    $pageView = 10;
    $pageLimit = ($pageView * $page) - $pageView;
    
    $sql = "SELECT youPhotoFile FROM myMember";
    $sql = "SELECT * FROM Community ORDER BY CommunityID DESC LIMIT {$pageLimit}, {$pageView}";
    $result = $connect -> query($sql);
?>

<?php foreach($result as $community){ ?>
    <article class='community'>
        <figuer class='community__header'>
            <a href="communityView.php?CommunityID=<?=$community['CommunityID']?>" style="background-image:url(../asset/img/community/<?=$community['communityImgFile']?>)"></a>
        </figuer>
        <div class="community__body">
            <div class="community__title"><a href="communityView.php?CommunityID=<?=$community['CommunityID']?>"><?=$community['communityTitle']?></a></div>
            <div class="community__info">
                <span class="author">
                    <div class="div">
                    <img src="../asset/img/mypage/face2.png" style="width: 36px; height: 36px;" alt=""><a href="#"><?=$community['communityAuthor']?></a>
                    </div>
                </span>
            </div>
        </div>
        <div class="community__footer">
              <span class="community__cate"><?=$community['communityCategory']?></span>
              <div class="footer__info">
                  <span>LIKE: <?=$community['communityLike']?></span>
              </div>
            <div class="footer__info">
                <span>조회수: <?=$community['communityView']?></span>
            <span class="date"><?=date('Y-m-d', $community['communityRegTime'])?></span>
            </div>
        </div>
    </article>
<?php } ?>
 
                    </div>
                    <div class="community__btn">
                        <a href="communityWrite.php">글쓰기</a>
                    </div>
                    <div class="community__search">
                        <form action="communitySearch.php" method="GET">
                            <fieldset class="underline">
                                <legend class="ir_so">검색 영역</legend>
                                <input type="search" name="communitySearch" id="communitySearch" class="search" placeholder="검색어를 입력해주세요!">
                                <label for="communitySearch" class="ir_so">검색</label>
                                <button class="button">검색</button>
                            </fieldset>
                        </form>
                    </div>
                    <div class="community__pages">
                        <ul>
                        <?php
    $result = $connect -> query($sql);
    $boardCount = $result -> fetch_array(MYSQLI_ASSOC);
    $boardCount = $boardCount['count(CommunityID)'];

    // echo "<pre>";
    // var_dump($boardCount);
    // echo "</pre>";

    //총 페이지 갯수
    $boardCount = ceil($boardCount/$pageView);

    //현재 페이지를 기준으로 보여주고 싶은 갯수
    $pageCurrent = 5;
    $startPage = $page - $pageCurrent;
    $endPage = $page + $pageCurrent;

    //처음 페이지 초기화
    if($startPage < 1) $startPage = 1;

    //마지막 페이지 초기화
    if($endPage >= $boardCount) $endPage = $boardCount;

    //이전 페이지
    if($page > 1){
        $prevPage = $page - 1;
        if ($keyword) {
            echo "<li><a href='community.php?page={$prevPage}&searchKeyword={$keyword}&searchOption={$searchType}'>이전</a></li>";
        } else {
            echo "<li><a href='community.php?page={$prevPage}'>이전</a></li>";
        }
    }

    //처음으로 페이지
    if($page > 1){
        if ($keyword) {
            echo "<li><a href='community.php?page=1'>처음으로</a></li>";
        } else {
            echo "<li><a href='community.php?page=1&searchKeyword={$keyword}&searchOption={$searchType}'>처음으로</a></li>";
        }
    }

    //페이지 넘버 표시
    for($i=$startPage; $i<=$endPage; $i++){
        $active = "";

        if($i == $page){
            $active = "active";
        }
        if ($keyword) {
            echo "<li class='{$active}'><a href='community.php?page={$i}&searchKeyword={$keyword}&searchOption={$searchType}'>{$i}</a></li>";
        } else {
            echo "<li class='{$active}'><a href='community.php?page={$i}' >{$i}</a></li>";
        }
    }

    //다음 페이지
    if($page < $endPage){
        $nextPage = $page + 1;
        if ($keyword) {
            echo "<li><a href='community.php?page={$nextPage}&searchKeyword={$keyword}&searchOption={$searchType}'>다음</a></li>";
        } else {
            echo "<li><a href='community.php?page={$nextPage}'>다음</a></li>";
        }
    }

    //마지막 페이지
    if($page < $endPage){
        if ($keyword) {
            echo "<li><a href='community.php?page={$boardCount}&searchKeyword={$keyword}&searchOption={$searchType}'>마지막으로</a></li>";
        } else {
            echo "<li><a href='community.php?page={$boardCount}'>마지막으로</a></li>";
        }
    }
?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- //main -->

    <!-- footer -->
    <?php
        include "../include/footer.php"    
    ?>
    <!-- //footer -->
    <script src="../asset/js/like.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
       
        

        function noticeRemove(){
            let notice = confirm("정말 삭제하시겠습니까?", "");
            return notice;
         }

         
   
    </script>
</body>
</html>