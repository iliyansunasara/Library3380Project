<?php
    include_once 'header.php';
?>



    <?php
        /*
        require_once 'includes/dbh-inc.php';

        $sql = "SELECT * FROM BOOK WHERE available = '1';";
        $result = $conn->query($sql) or die($conn->error);

        while ($data = $result->fetch_assoc()) {
            echo "<img src='$data['cover']' width='40%' height='40%'>";
            echo "<h2>$data['Title']</h2>";
            echo "<h2>$data['Author']</h2>";
        }


        $sql = "SELECT * FROM ITEM WHERE available = '1';";
        $result = $conn->query($sql) or die($conn->error);

        while ($data = $result->fetch_assoc()) {
            echo "<h2>$data['name']</h2>";
        }

        */
    ?>
<?php
    include_once 'footer.php';
?>