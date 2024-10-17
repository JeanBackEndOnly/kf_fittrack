<?php
    require_once '../../include/session.php';
    require_once '../../include/config.php';
    require_once '../functionalities/all_view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member</title>
    <link rel="stylesheet" type="text/css" href="../../css/admin_contract.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="header">
        <div class="search-form">
            <form action="contract_Index.php" method="post">
                    <button class="search-button"><img src="../../image/searching-icon.png"></button>
                    <input type="text" name="search" placeholder="Search Member:">
                </form>
            </div>
            <div class="delete-error">
                        <?php
                            noContract();
                            deleteContract_success();
                        ?>
                    </div>
            <div class="side-nav">
                <div class="user">
                   <img src="../../image/logo.png" class="user-img">
                </div>
                <div class="navs-div">
                    <ul class="nav-ul">
                        <a href="../dashboard/dashboard_index.php" id="a-nav"><li id="dashboard-li"><img src="../../image/dashboard-icon.png" class="dashboard-img"><p>DASHBOARD</p></li></a>
                        <a href="../membership/membership_Index.php" id="a-nav"><li id="members-li"><img src="../../image/membership.png" class="members-img"><p>MEMBERSHIP</p></li></a>
                        <a href="../contract/contract_Index.php" id="a-nav"><li id="contract-li"><img src="../../image/contract-logo.png" class="contract-img"><p class="contract-p">CONTRACT</p></li></a>
                    </ul>
                </div>
                <ul class="logout-ul">
                    <a href="../logout.php"><li id="logout-li"><img src="../../image/logout-icon.png" class="logout-img"><p>LOGOUT</p></li></a>
                </ul>
            </div>
        <div class="members-profile">
            <?php  
                if (isset($_POST['search'])) {
                    $searchQuery = $_POST['search'];
                
                    try {
                        if (is_numeric($searchQuery)) {
                            $query = "SELECT * FROM members
                            LEFT JOIN users ON members.users_id = users.id
                            LEFT JOIN contract ON members.member_id = contract.members_id
                            WHERE member_id = :searchQuery";
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(":searchQuery", $searchQuery, PDO::PARAM_INT);
                        } else {
                            $query = "SELECT * FROM members
                            LEFT JOIN users ON members.users_id = users.id
                            LEFT JOIN contract ON members.member_id = contract.members_id
                            WHERE fullName LIKE :searchQuery";
                            $stmt = $pdo->prepare($query);
                            $searchTerm = "%" . $searchQuery . "%"; 
                            $stmt->bindParam(":searchQuery", $searchTerm, PDO::PARAM_STR);
                        }
                
                        $stmt->execute();
                        $searchResult = $stmt->fetch(PDO::FETCH_ASSOC);
                
                        if ($searchResult) {
                            echo '<ul class="image-div">';
                                echo '<div class="expired-ul">';
                                    echo '<a href="contract_Index.php?" id="home-button"><img src="../../image/arrow-icon.png" id="arrow-back"></a>';
                                        echo isset($searchResult["profile_picture"]) ? '<li><img src="../../upload_images/' . $searchResult["profile_picture"] . '"></li>' : '<li><img src="../../image/logo.png"></li>';
                                        echo '<div class="id-div">';
                                            echo '<li>ID# ' . $searchResult["member_id"] . '</li>';
                                            echo '<li>' . $searchResult["fullName"] . '</li>';
                                        echo '</div>';
                                        echo '<div class="contract-div">';
                                            echo '<li id="renewal-li">CONTRACT RENEWAL: </li>';
                                            echo isset($searchResult["contract_Renewal"]) ? '<li id="renewal-li">' . $searchResult["contract_Renewal"] . '</li>' : '<li id="renewal-li">NO CONTRACT</li>';
                                        echo '</div>';
                                        echo '<div class="buttons-domain-expansion">';
                                        echo '<button class="deleteButton" onclick="showPopup(' . $searchResult['id'] . ')" id="buttons-delete">
                                                <img src="../../image/delete-icon.png" id="delete-icon">DELETE</button>';
                                        echo '<a href="search_Index.php?member_id=' . $searchResult["member_id"] . '" id="button-view"><img src="../../image/view-icon.png" id="view-icon">VIEW</a>';
                                        echo '<a href="add_Index.php?member_id=' . $searchResult["member_id"] . '" id="button-add"><img src="../../image/add-icon.png" id="add-icon">ADD</a>';
                                        echo '</div>';
                                        
                                        echo '<div id="confirmPopup-' . $searchResult['id'] . '" class="popup" style="display: none;">
                                                <div class="popup-content">
                                                    <h2>Are you sure you want to delete this member?</h2>
                                                    <div class="button-popup">
                                                        <form action="../functionalities/contract_Delete.php?members_id=' . $searchResult["members_id"] . '" method="post">
                                                            <input type="hidden" name="id" value="' . $searchResult['id'] . '">
                                                            <input type="hidden" name="members_id" value="' . $searchResult["members_id"] . '">
                                                            <button type="submit" id="yesButton">YES</button>
                                                        </form>
                                                        <button id="noButton" onclick="hidePopup(' . $searchResult['id'] . ')">NO</button>
                                                    </div>
                                                </div>
                                            </div>';
                                    '</div>';
                            echo '</ul>';
                        } else {
                            echo '<div class="no-result-found">';
                                echo '<p class="no-result">No results found</p>';
                                echo '<a href="contract_Index.php">>>view other members<<</a>';
                            echo '</div>';
                        }
                    } catch (PDOException $e) {
                        die("Query Failed: " . $e->getMessage());
                    }
                } else{ 
                $sql = "SELECT contract.*, users.*, members.* FROM members
                INNER JOIN users ON members.users_id = users.id 
                INNER JOIN contract ON members.member_id = contract.members_id;";
                $stmt = $pdo->query($sql);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                foreach($result as $row){
                    echo '<ul class="image-div">';
                        echo '<div class="expired-ul">';
                            echo isset($row["profile_picture"]) ? '<li><img src="../../upload_images/' . $row["profile_picture"] . '"></li>' : '<li><img src="../../image/logo.png"></li>';
                            echo '<div class="id-div">';
                                echo '<li>ID# ' . $row["member_id"] . '</li>';
                                echo '<li>' . $row["fullName"] . '</li>';
                            echo '</div>';
                            echo '<div class="contract-div">';
                                echo '<li id="renewal-li">CONTRACT RENEWAL: </li>';
                                echo isset($row["contract_Renewal"]) ? '<li id="renewal-li">' . $row["contract_Renewal"] . '</li>' : '<li id="renewal-li">NO CONTRACT</li>';
                            echo '</div>';
                            echo '<div class="buttons-domain-expansion">';
                            echo '<button class="deleteButton" onclick="showPopup(' . $row['id'] . ')" id="buttons-delete">
                                    <img src="../../image/delete-icon.png" id="delete-icon">DELETE</button>';
                            echo '<a href="search_Index.php?member_id=' . $row["member_id"] . '" id="button-view"><img src="../../image/view-icon.png" id="view-icon">VIEW</a>';
                            echo '<a href="add_Index.php?member_id=' . $row["member_id"] . '" id="button-add"><img src="../../image/add-icon.png" id="add-icon">ADD</a>';
                            echo '</div>';
                            echo '<div id="confirmPopup-' . $row['id'] . '" class="popup" style="display: none;">
                                    <div class="popup-content">
                                        <h2>Are you sure you want to delete this member?</h2>
                                        <div class="button-popup">
                                            <form action="../functionalities/contract_Delete.php?members_id=' . $row["members_id"] . '" method="post">
                                                <input type="hidden" name="id" value="' . $row['id'] . '">
                                                <input type="hidden" name="members_id" value="' . $row["members_id"] . '">
                                                <button type="submit" id="yesButton">YES</button>
                                            </form>
                                            <button id="noButton" onclick="hidePopup(' . $row['id'] . ')">NO</button>
                                        </div>
                                    </div>
                                </div>';
                            '</div>';
                    echo '</ul>';
                        
                    }
                }
            ?>
        </div>
    </div>

    <script>
        function showPopup(id) {
            console.log("Popup ID:", id); 
            const popup = document.getElementById(`confirmPopup-${id}`);
            if (popup) {
                popup.style.display = "flex";
            } else {
                console.log("Popup with ID not found:", id);
            }
        }
        function hidePopup(id) {
            const popup = document.getElementById(`confirmPopup-${id}`);
            popup.style.display = "none";
        }
        window.onclick = function(event) {
            const popups = document.querySelectorAll('.popup');
            popups.forEach(function(popup) {
                if (event.target === popup) {
                    popup.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>