<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File system browser</title>
</head>
<body>
    <?php

        $dir = scandir(".");
        foreach ($dir as $file)
        {
            if (is_dir($file))
            {
                echo "Folder: ".$file."<br>";
            } elseif (is_file($file)) {
                echo "File: ".$file."<br>";
            }
            else
            {
                echo "File doesn't exist";
            }
        }
    ?>
</body>
</html>
    