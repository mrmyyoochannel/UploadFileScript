<?php
$currentDirectory = getcwd();
$uploadDirectory = "/uploads/";

$errors = []; // Store errors here

$fileExtensionsAllowed = ['jpeg','jpg','png','pdf','py','rar','mp4','exe','c','ccp']; // These will be the only file extensions allowed 

if(isset($_FILES['the_file'])) {
    $fileName = $_FILES['the_file']['name'];
    $fileSize = $_FILES['the_file']['size'];
    $fileTmpName  = $_FILES['the_file']['tmp_name'];
    $fileType = $_FILES['the_file']['type'];
    $fileExtensionArray = explode('.', $fileName);
    $fileExtension = strtolower(end($fileExtensionArray));

    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 

    if (isset($_POST['submit'])) {

        if (!in_array($fileExtension, $fileExtensionsAllowed)) {
            $errors[] = "This file extension is not allowed. Please upload a 'jpeg','jpg','png','pdf','py','rar','mp4','exe','c','ccp' file";
            echo "<script>alert('File extension not allowed');</script>";
        }

        if ($fileSize > 3221225472) {  // 3 GB in bytes
            $errors[] = "File exceeds maximum size (3 GB)";
            echo "<script>alert('File size exceeds maximum limit');</script>";
        }

        if (empty($errors)) {
            $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

            if ($didUpload) {
                echo "The file " . basename($fileName) . " has been uploaded";
                echo "<script>alert('File uploaded successfully!');</script>";
                header('Location: '.$_SERVER['REQUEST_URI']);
                exit;
            } else {
                echo "An error occurred. Please contact the administrator.";
                echo "<script>alert('Error uploading the file');</script>";
            }
        } else {
            foreach ($errors as $error) {
                echo $error . "These are the errors" . "\n";
                echo "<script>alert('Error: $error');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 18px 32px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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

        .progress-container {
            width: 99%;
            background-color: #ddd;
            border-radius: 4px;
            margin-top: 10px;
        }

        .progress-bar {
            width: 0;
            height: 20px;
            background-color: #4caf50;
            text-align: center;
            line-height: 20px;
            color: #fff;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <form action="index.php" method="post" enctype="multipart/form-data" onsubmit="move()">
        <h2>File Upload (1GBMAX)</h2>
        <label for="fileToUpload">Choose a file:</label>
        <input type="file" name="the_file" id="fileToUpload">
        <input type="submit" name="submit" value="Upload">

        <div class="progress-container">
            <div class="progress-bar" id="myBar">0%</div>
        </div>
		<a href="filelist.php">filelist</a>
    </form>

    <script>
        // Simulate progress bar update (0-100%)
        function move() {
            var elem = document.getElementById("myBar");
            var width = 0;
            var id = setInterval(frame, 10);
            function frame() {
                if (width >= 98) {
                    clearInterval(id);
                } else {
                    width++;
                    elem.style.width = width + "%";
                    elem.innerHTML = width + "%";
                }
            }
        }
    </script>
</body>
</html>
