<!DOCTYPE html>
<html lang="en">
<?php
$page = $_SERVER['PHP_SELF'];
$sec = "10";
?>
<head>
	<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <meta charset="UTF-8">
    <title>File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        h2 {
            color: #333;
        }

        p {
            margin: 5px 0;
        }

        a {
            text-decoration: none;
            color: #0066cc;
        }

        div {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div>
        <h2>File Directory Listing</h2>

        <?php
        // Specify the directory path
        $directory = './uploads/';

        // Get all files in the directory
        $files = scandir($directory);

        // Display each file with date and time
        foreach ($files as $file) {
            // Exclude current directory (.) and parent directory (..)
            if ($file != "." && $file != "..") {
                // Get the file creation time
                $fileCreationTime = date("Y-m-d H:i:s", filectime($directory . $file));

                echo '<p><strong>File:</strong> <a href="' . $directory . $file . '" download>' . $file . '</a>';
                echo ' - <strong>Uploaded on:</strong> ' . $fileCreationTime . '</p>';
            }
        }
        ?>
    </div>
	    <?php
        echo "Watch the page reload itself in 10 second!";
    ?>
</body>
<a href="index.php">home</a>
</html>