<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $youEmail = $_POST['youEmail'];
        $youName = $_POST['youName'];
        $youAddress = $_POST['youAddress'];
        $youAddress2 = $_POST['youAddress2'];
        $youPass = $_POST['youPass'];
        $memberID = $_SESSION['memberID'];

        $youPhotoFile = $_FILES['youPhotoFile'];
        $youPhotoSize = $_FILES['youPhotoFile']['size'];
        $youPhotoType = $_FILES['youPhotoFile']['type'];
        $youPhotoName = $_FILES['youPhotoFile']['name'];
        $youPhotoTmp = $_FILES['youPhotoFile']['tmp_name'];

        $fileTypeExtension = explode("/", $youPhotoType);
        $fileType = $fileTypeExtension[0]; //image
        $fileExtension = $fileTypeExtension[1]; //jpeg

        // $youPhotoName = "IMG_".time().rand(1,99999)."."."{$fileExtension}";
        // var_dump($youPhotoName);

        $sql = "SELECT youPass, memberID FROM myMember WHERE memberID = {$memberID}";
        $result = $connect -> query($sql);
        if($result){
            $memberInfo = $result -> fetch_array(MYSQLI_ASSOC);
            //아이디 비밀번호 확인
            if($memberInfo['youPass'] == $youPass){
                //수정(쿼리문 작성)
                $sql = "UPDATE myMember SET youEmail = '{$youEmail}', youName = '{$youName}', youBirth = '{$youBirth}', youPhone = '{$youPhone}' WHERE memberID = '{$memberID}'";
                $connect -> query($sql);
                echo "<script>history.back(1);</script>";
    
            } else {
                echo "<script>alert('비밀번호가 일치하지 않습니다. 다시 한 번 확인해주세요!'); history.back(1);</script>";
            }
        } 
        
        // echo "<pre>";
        // var_dump($result);
        // echo "</pre>";
        $result =  $connect -> query($sql);
        $result = move_uploaded_file($youPhotoTmp, $youPhotoDir.$youPhotoName);      
    ?>
    <script>
        location.href = "../mypage/mypage.php";
    </script>
</body>
</html>
