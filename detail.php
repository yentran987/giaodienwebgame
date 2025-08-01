<html>
    <head>
        <link href="bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                max-width: 1200px;
                margin: 0 auto;
            }
            .menu {
                background-color: #212529;
                margin: 0px;
            }
            .menu li {
                color: white;
                display: inline-block;
                padding: 15px;
            }
            .menu li a {
                color: white;
                text-decoration: none;
            }
            .main {
                margin-top: 10px;
                display: grid;
                grid-template-columns: 22% 76%;
                grid-gap: 2%;
            }
            .description h1, .description h3, p {
                margin: 0 0 10px 0;
            }
            p {
                line-height: 1.3;
            }
            a {
                text-decoration: none;
                color: black;
            }
            .co {
                float: right;
                margin-right: 20px;
                margin-top: 10px;
            }

        </style>
     
    </head>

    
    <body>
        <!-- Bổ sung thêm code để hoàn thiện bài thi -->
        <div class='header'>
            <img src="banner" style="max-width:100%;">
            <?php
                require_once "config.php";
                $sql = "select * from roles";
                $roles = [];
                $result = $conn->query($sql);
                if ($result) {
                    $roles = $result->fetch_all(MYSQLI_ASSOC);
                }

                $lang = isset($_GET['lang']) && $_GET['lang'] === 'vi' ? 'vi' : 'en';

                $laydl = $_GET;
                
                // Tạo URL với ngôn ngữ là 'vi'
                $laydl['lang'] = 'vi';
                $langViUrl = '?' . http_build_query($laydl);
                
                // Tạo URL với ngôn ngữ là 'en'
                $laydl['lang'] = 'en';
                $langEnUrl = '?' . http_build_query($laydl);
        
                ?>
                <ul class="menu">
                    <?php
                        foreach($roles as $role) { ?>
                        
                            <li><a href="http://lambai.hub.vn/source_code/index.php?role=<?php echo $role['role_name_' . $lang]; ?>&lang=<?php echo $lang; ?>">
                                <?php echo $role['role_name_' . $lang]; ?></a></li>
                        <?php } ?>
                    <div class="co">
                 <a href="<?php echo $langViUrl; ?>"><img src="vi.gif" style="width:30px;" alt="Vietnamese"></a>
              <a href="<?php echo $langEnUrl; ?>"><img src="en.gif" style="width:30px;" alt="English"></a>
                </div>

                </ul>
            </div>
    
            <div class="main">
                <?php
                    if (isset($_GET['champion_id'])) {
                        $champion_id = $_GET['champion_id'];
    
                        // Lấy thông tin chi tiết của nhân vật
                        $sql = "SELECT * FROM champions WHERE id = $champion_id";
                        $result = $conn->query($sql);
    
                        if ($result) {
                            $champion = $result->fetch_assoc();
                            ?>
                            <div>
                                <img src="./img/<?php echo $champion['image']; ?>" style="width:100%;">
                            </div>
                            <div class="description">
                                <h1><?php echo $champion['supertitle_' . $lang]; ?></h1>
                                <h3><?php echo $champion['title_' . $lang]; ?></h3>
                                <p><?php echo $champion['description_' . $lang]; ?></p>
                                <p><strong>Role:</strong> <?php echo $champion['role_' . $lang]; ?></p>
                                <p><strong>Difficulty:</strong> <?php echo $champion['difficulty_' . $lang]; ?></p>
                                <div>
                                    <h4>Skills:</h4>
                                    <div style="display:flex; gap:10px;">
                                        <?php
                                            // Lấy danh sách kỹ năng của nhân vật
                                            $sql_skills = "SELECT * FROM skills WHERE champion_id = $champion_id";
                                            $result_skills = $conn->query($sql_skills);
    
                                            if ($result_skills) {
                                                foreach ($result_skills->fetch_all(MYSQLI_ASSOC) as $skill) {
                                                    ?>
                                                    <div style="text-align:center; cursor:pointer;">
                                                    <a href= "<?php echo $skill['skill_video_link']; ?>">
                                                        <img src="./img_skill/<?php echo $skill['skill_image']; ?>" style="width:50px; height:50px;">
                                                        <p><?php echo $skill['skill_name_' . $lang]; ?></p>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
    
   


    </body>
</html>