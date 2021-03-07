<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File System Browser</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
$current = $_SERVER['REQUEST_URI'];

// download
if(isset($_POST['download'])){
    $file='./' . $_POST['download'];
    $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
    ob_clean();
    ob_start();
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf'); 
    header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileToDownloadEscaped)); 
    ob_end_flush();
    readfile($fileToDownloadEscaped);
    exit;
}

// upload
if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));
    $extensions = array("jpeg","jpg","png");
    if(in_array($file_ext,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
    if($file_size > 2097152) {
        $errors[]='File size must be smaller than 2 MB';
    }
    if(empty($errors)==true) {
        move_uploaded_file($file_tmp, $file_name);
        echo '<p style="color: red;">An image uploaded successfully!</p>';
    }else{
        print_r($errors);
    }
}

// delete
if(isset($_POST['delete'])) {
    $fileToDelete = $_GET['path'] . $_POST['delete'];
        unlink($fileToDelete);
}

// make a new directory
if(isset($_POST['dir-name'])) {
    $newDir = $_GET['path']. $_POST['dir-name'];
    if (is_dir($_POST['dir-name'])) {
        echo '<p style="color: red;">Folder with a name ' . $_POST['dir-name'] . ' exists aleready</p>';
    } elseif (empty($_POST['dir-name'])) {
        echo '<p style="color: red;">Folder name cannot be empty. Please eneter a new folder name!</p>';
    } else {
        mkdir($newDir);
    }

    }


?>


<h1>Hello! Welcome to the PHP File System browser</h1>
    <p>Now you are here: <?php  echo $current; ?></p>
    

    <table>
        <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>

        <?php

$path = './' . $_GET['path'];

$dir = scandir($path);

foreach ($dir as $key) {
if ($key == '.' || $key == '..') {
    continue;
} elseif (is_dir($path . $key)) {
    echo
    "<tr>
                        <td>Directory</td>
                        <td> 
                        <a href=" . $current . '?path=' . $key . '/>' . $key . "</a>
                        </td>
                        <td></td>
                       
                    </tr>";
} elseif (is_file($path . $key)) {
    echo 
    '<tr>
        <td>File</td>
        <td>' . $key . '</td>
        <td> 

        <form action="?path=' . $key . '" method="POST">
        <button type="submit" name="download" value="' . $key . '"/>DOWNLOAD</button>
        </form>

        
        <form action="" method="POST">
        <button type="submit" name="delete" value="' . $key . '"/>DELETE</button>
        </form>

        </td>
    </tr>';
} 


}

?>

        </table>

        <div style="background-color: violet;">
        <form action="" method="POST">
            <p>Create a new directory!</p>
            <label for="dir-name">Enter a new directory name: </label>
            <input type="text" name="dir-name">
                <input type="submit" value="Create">

            
            <!-- <input type="text" name="dir-name">
            <button type = "submit" name="dir-name">Create</button> -->

        </form>
</div>


<div style="background-color: lightblue;">
<p>Please upload your image (JPEG or PNG):</p>
    <form action = "" method = "POST" enctype = "multipart/form-data">
        <input type = "file" name = "image" />
        <input type = "submit"/>
    </form>
    </div>

    <div style="background-color: lightgreen;">
    <p>Here is info about your image file:</p>
    <ul>
        <li>Sent file: <?php echo $_FILES['image']['name'];  ?>
        <li>File size: <?php echo $_FILES['image']['size'];  ?>
        <li>File type: <?php echo $_FILES['image']['type'] ?>
    </ul>

</div>




</body>
</html>