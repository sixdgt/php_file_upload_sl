<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload | PHP</title>
</head>
<body>
    <h1>File Upload | PHP</h1>
    <hr>
    <form action="file_upload_handler.php" method="post" enctype="multipart/form-data">
        <label for="full_name">Full Name</label><br><br>
        <input type="text" name="full_name" placeholder="Full Name"><br><br>
        
        <label for="email">Email</label><br><br>
        <input type="email" name="email" placeholder="Email"><br><br>

        <label>Select file you want to upload</label><br><br>
        <input type="file" name="file_to_upload"><br><br>
        <input type="submit" value="Upload Image" name="upload">
    </form>
    <br><br>
    <hr>
    <h1>User File Details</h1>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php
                require_once "get_user_data.php";

                $data = displayUserFile();
               
                for($i = 0; $i < sizeof($data); $i++){
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $data[$i]['full_name']; ?></td>
                        <td><?php echo $data[$i]['email']; ?></td>
                        <td><img src="<?php echo "{$data[$i]['file_url']}"; ?>" alt=""><?php echo "{$data[$i]['file_url']}";?></td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>
</body>
</html>