<h1>Hello! Welcome to the PHP File System browser</h1>
    <p>Now you are here: <?php $current = $_SERVER['REQUEST_URI']; echo $current ;?></p>
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
                        <td>ACTION</td>
                    </tr>";

                   


                } elseif (is_file($path . $key)) {
                    echo 
                    "<tr>
                        <td>File</td>
                        <td>$key</td>
                        <td> 
                            <form action=\"\" method=\"\">
                            <button type=\"submit\" name=\"delete\" value=\"{$key}\">
                                DELETE
                            </button>
                            </form>
                           
                        </td>
                    </tr>";
                    // if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    //     //                 $joinString = $path . $key;
                    //     //                 $file = fopen($joinString);
                    //     // echo fwrite($file,"Hello World. Testing!");
                    //     // fclose($file);
                        
                    //     unlink($path . $key);
                    // }
                    
                } 

                
            }

            

//             if ($_SERVER["REQUEST_METHOD"] == "POST") {
// //                 $joinString = $path . $key;
// //                 $file = fopen($joinString);
// // echo fwrite($file,"Hello World. Testing!");
// // fclose($file);

// unlink($path . $key);

// // $file_pointer = "hh.html";  
   
// // // Use unlink() function to delete a file  
// // if (!unlink($file_pointer)) {  
// //     echo ("$file_pointer cannot be deleted due to an error");  
// // }  
// // else {  
// //     echo ("$file_pointer has been deleted");  
// // }  
//             }
            
       
        ?>

        
    </table>
    <br>

    <div style="background-color: lightblue;">
    <form method="POST">
            <label for="dirname">Enter a new directory name</label>
            <input type="text" name="dirname" for="dirname" placeholder="New Directory Name...">
            <button type="submit" name="dirname">CREATE</button>
            </form>
            </div>

            <?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     mkdir('.');
// }



            ?>
            <br>

            <?php
        print_r($_FILES);
        // file download logic
        if(isset($_POST['download'])){
            // print('Path to download: ' . './' . $_GET["path"] . $_POST['download']);
            $file='./' . $_POST['download'];
            // a&nbsp;b.txt --> a b.txt
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
        // file upload logic
        if(isset($_FILES['image'])){
            $errors = array();

            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_type = $_FILES['image']['type'];

            // check extension (and only permit jpegs, jpgs and pngs)
            $file_ext = strtolower(end(explode('.',$_FILES['image']['name']))); // telia_bill.PDF --> 'telia_bill', 'PDF' --> 'pdf'
            $extensions = array("jpeg","jpg","png");
            if(in_array($file_ext, $extensions) === false){
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
            }
            if($file_size > 2097152) {
                $errors[] = 'File size must be excately 2 MB';
            }
            if(empty($errors) == true) {
                move_uploaded_file($file_tmp, "./" . $path . $file_name);
                echo "Success";
            } else {
                print_r($errors);
            }
        }

    ?>

<div style="background-color: pink;">
<p>Please upload the file</p>
<form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="image" />
         <input type="submit"/>
      </form>

      <ul>
        <li>Sent file: <?php echo $_FILES['image']['name'];  ?>
        <li>File size: <?php echo $_FILES['image']['size'];  ?>
        <li>File type: <?php echo $_FILES['image']['type'] ?>
    </ul>


</div>


<div style="background-color: salmon">
<p>you can download one of these from this page:</p>
 <?php
        $dir_contents = scandir('./');
        foreach($dir_contents as $content){
            if(is_file($content)){
                print('<form action="?path=' . $content . '" method="POST">');
                print('<input type="submit" name="download" value="' . $content . '"/>');
                print('</form>');
            }
        }
    ?> 
</div>






