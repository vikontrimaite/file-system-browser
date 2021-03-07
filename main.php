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

if(isset($_POST['download'])){
    // print('Path to download: ' . './' . $_GET["path"] . $_POST['download']);
    $file='./' . $_POST['download'];
    // a&nbsp;b.txt
    // a b.txt
    $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, null, 'utf-8'));
    ob_clean();
    ob_start();
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf'); // mime type → ši forma turėtų veikti daugumai failų, su šiuo mime type. Jei neveiktų reiktų daryti sudėtingesnę logiką
    header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileToDownloadEscaped)); // kiek baitų browseriui laukti, jei 0 - failas neveiks nors bus sukurtas
    ob_end_flush();
    readfile($fileToDownloadEscaped);
    exit;
}

// if(isset($_POST['delete'])){
//     $deleteFile= $_POST['delete'];
//     // $_GET['path'] .
//     unlink($deleteFile);
//                 header('Location: ' . $current);
// }

// print_r($_FILES);
if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    // check extension (and only permit jpegs, jpgs and pngs)
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
        echo "Success";
    }else{
        print_r($errors);
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

        <form action="?path=' . $key . '" method="POST">
        <button type="submit" name="delete" value="' . $key . '"/>DELETE</button>
        </form>

        </td>
    </tr>';
} 


}

?>

        </table>

        <br>



<div>

    <form action = "" method = "POST" enctype = "multipart/form-data">
        <input type = "file" name = "image" />
        <input type = "submit"/>
    </form>
    <ul>
        <li>Sent file: <?php echo $_FILES['image']['name'];  ?>
        <li>File size: <?php echo $_FILES['image']['size'];  ?>
        <li>File type: <?php echo $_FILES['image']['type'] ?>
    </ul>

</div>


</body>
</html>