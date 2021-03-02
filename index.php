<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File system browser</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Hello! Welcome to the PHP File System browser</h1>
    <p>Now you are here: <?php echo $_SERVER['REQUEST_URI'];?></p>
    <table>
        <tr>
            <th>Type</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>

        <?php
            $dir = scandir('.');
            
            foreach ($dir as $key) {
                if ($key == '.' || $key == '..') {
                    continue;
                } elseif (is_file($key)) {
                    echo 
                    "<tr>
                        <td>File</td>
                        <td>$key</td>
                        <td>ACTION</td>
                    </tr>";
                } 
                elseif (is_dir($key)) {
                            echo
                            "<tr>
                                <td>Directory</td>
                                <td><a href=\"./$key\">$key</a></td>
                                <td>ACTION</td>
                            </tr>";
                    }
                    
                } 
            
        ?>
    </table>
</body>
</html>
    