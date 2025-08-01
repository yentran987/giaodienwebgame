<html>
    <head>
        <style>
          body {
                max-width: 1200px;
                margin: 0 auto;
            }
            .menu {
                background-color: #212529;
                margin: 0px;
                padding: 0;
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
            .grid {
                display: grid;
                grid-template-columns: repeat(5,19.5%);
                gap: 0.625%;
            }
            .item {
                border : 1px solid #cecece;
                text-align: center;
            }
            .item img {
                width: 100%;
               
            }
            .item a{
              color:black;
             text-decoration: none;
            }

        </style>
    </head>
    <body>
        <!--Bổ sung code để hoàn thiện theo yêu cầu bài thi-->
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
    
            ?>

            <ul class="menu">
                <?php 
                    foreach($roles as $row)
                    { ?>
                    <li><a href="http://lambai.hub.vn/source_code/index.php?role=<?php echo $row['role_name_en']; ?>"><?php echo $row['role_name_en'];?></a></li>
                   <?php
                    }
                ?>
                <li><a href="http://lambai.hub.vn/source_code/index.php?role=DualRole">Dual Role</a></li>
            </ul>
        </div>
        <div class="main">
            <div class="grid">
 <?php

                    $selected_role = isset($_GET['role']) ? $_GET['role'] : 'Tank';

                    if ($selected_role === 'DualRole') {
                        // Lấy danh sách nhân vật có hơn một vai trò
                        $sql = " select * from champions s where 1 < (select count(*) from champion_role where champion_id = s.id)
                            LIMIT 20";
                    } else {
                        $role_id=$conn->query("SELECT id FROM roles WHERE role_name_en = '$selected_role'")->fetch_assoc()["id"];
                        // Lấy danh sách nhân vật theo vai trò
                        $sql = "
                            SELECT * 
                            FROM champions c, champion_role cr
                            WHERE c.id = cr.champion_id and cr.role_id = $role_id
                            LIMIT 20";
                        }
                

                    $result = $conn->query($sql);

                    if ($result) {
                        $nv = $result->fetch_all(MYSQLI_ASSOC);

                        foreach ($nv as $row) { ?>
                            <div class="item">
                                <a href="detail.php?champion_id=<?php echo $row['id']; ?>">
                                    <img src="./img/<?php echo $row['image']; ?>" alt="<?php echo $row['supertitle_en']; ?>">
                                    <h3><?php echo $row['supertitle_en']; ?></h3>
                                    <p><?php echo $row['title_en']; ?></p>
                                </a>
                            </div>
                        <?php }
                    }
                ?>
            </div>

        </div>
    </body>
</html>