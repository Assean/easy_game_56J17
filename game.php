<?php 
    // PHP 部分完全保留，禁止進行任何更變
    session_start();
    $games=[];
    $handle=opendir('games');
    if($handle){
        while(false!==($entry=readdir($handle))){
            if($entry !="." && $entry !=".."){
                $json_path = "games/".$entry."/game.json";
                if(file_exists($json_path)){
                    $data=json_decode(file_get_contents($json_path),true);
                    $data['path']="games/".$entry."/index.html";
                    $games[]=$data;
                }
            }
        }
        closedir($handle);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FunTech | 遊戲平台</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/jqueryv3.7.1.js"></script>
    <script>
        let ag, lg;
        function receiveGameResult({ game, data, user }) {
            $("#gameTitle").text(game);
            $("#gameStatus").text(data.result);
            $("#gameTime").text(data.time + " 秒");
            $.post('api/save_result.php', { 
                game: game,
                user: user,
                result: data.result,
                time: data.time 
            });
        }
        const openGame = (u, t) => { 
            ag = t;
            lg = u; 
            window.open(u, 'G', 'width=700,height=700'); 
        };
    </script>
</head>

<body>
    <?php include_once "./include/header.php";?>

    <div class="container">
        <h1 class="text-center my-4">遊戲平台</h1>
        
        <div>
            <p>遊戲：</p><span id="gameTitle"></span><br>
            <p>狀態：</p><span id="gameStatus"></span><br>
            <p>時間：</p><span id="gameTime"></span>
        </div>

        <div>
            <?php foreach($games as $game): ?>
                <div>
                    <div>
                        <b><?= $game['title']; ?></b>
                        <div>
                            <?= mb_strimwidth($game['description'], 0, 50, "..."); ?>
                        </div>
                        <button class="btn btn-info btn-sm mt-2" 
                        onclick="openGame('<?= $game['path']; ?>','<?= $game['title']; ?>')">
                        開始遊戲</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include_once("./include/footer.php"); ?>
    <script src="js/bootstrap.js"></script>
</body>
</html>