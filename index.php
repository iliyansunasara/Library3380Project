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


    <form action="" method="POST" enctype = "multipart/form-data">
        <input type="file" name ="userfile[]" value = "" multiple = "">
        <input type="submit" name="submit" value = "Upload">

    <?php

    require_once 'includes/dbh-inc.php';

    $table = "BOOK or ITEM";

    $phpFileUploadErrors = array(
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',  
        6 => 'Messing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',
    );
    //$_$FILES
    if(isset($_FILES['userfile'])) {
        $file_array = reArrayFiles($_FILES['userfile']);
        //pre_r($file_array);
        for ($i=0; $i < count($file_array); $i++) {
            if($file_array[$i]['error']) {
                ?> <div class="alert alert-danger">
                <?php echo $file_array[$i]['name'].'-'.$phpFileUploadErrors[$file_array[$i]['error']];
                ?> </div> <?php
            }
            else {
                $extensions = array('jpg', 'png', 'gif', 'jpeg'); // MAYBE CAPITALIZE FIX???

                $file_ext = explode('.', $file_array[$i]['name']);

                $name = $file_ext[0];
                $name = preg_replace("!-!"," ",$name);
                $name = ucwords($name);
                
                $file_ext = end($file_ext);

                if (!in_array($file_ext, $extensions)) {
                    ?> <div class="alert alert-danger">
                    <?php echo "{$file_array[$i]['name']} - Invalid file extenstion";
                    ?> </div> <?php
                }
                else {
                    $img_dir = 'covers/'.$file_array[$i]['name'];
                    move_upload_file($file_array[$i]['tmp_name'], $img_dir);

                    $sql = "INSERT INTO BOOK(cover) VALUES('$img_dir');"; //FIX ME!!!!!!
                    $conn->query($sql) or die($conn->error);
                    ?> <div class="alert alert-success">
                    <?php echo $file_array[$i]['name'].'-'.$phpFileUploadErrors[$file_array[$i][$error]];
                    ?> </div> <?php
                }
            }
        }
    }
    function reArrayFiles(&$file_post){
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for($i=0; $i<$file_count; $i++) {
            foreach($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }
    function pre_r($array){
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
    ?>
<?php
    include_once 'footer.php';
?>