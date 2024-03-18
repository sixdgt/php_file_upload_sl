<?php
$connect = mysqli_connect("localhost", "sixdgt", "1234", "test_file_upload");

function saveUserFile($connect, $full_name, $email, $file_url){

    $sql = "INSERT INTO test_user_files(`full_name`, `email`, `file_url`) VALUES('$full_name', '$email', '$file_url')";

    try{
        $res = mysqli_query($connect, $sql);
        if($res){
            echo "Stored successfully";
        }
    } catch (Exception $e){
        echo "Something went wrong. Please try again.";
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $upload_dir = "uploads/";

    // checking if the dir exists or not
    if(!is_dir($upload_dir)){
        // creating new dir with mkdir() function
        mkdir($upload_dir);
    }
    $upload_file_target = $upload_dir.basename($_FILES['file_to_upload']['name']);
    // checking if the file is submitted or not
    if(isset($_FILES['file_to_upload']) && $_FILES['file_to_upload']['error'] == 0){
        // file extension config array
        $file_ext_config = array(
            "png" => "image/png",
            "jpg" => "image/jpg",
            "jpeg" => "image/jpeg",
            "PNG" => "image/PNG",
            "JPG" => "image/JPG",
            "JPEG" => "image/JPEG",
        );

        // time() - returns current timestamp
        
        // file name, size, type and temp name
        $file_name = time().$_FILES['file_to_upload']['name']; // file name
        $file_type = $_FILES['file_to_upload']['type']; // file type
        $file_size = $_FILES['file_to_upload']['size']; // file size
        $file_tmp_name = $_FILES['file_to_upload']['tmp_name']; // file temp name

        // file extension
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        // checking file extension according to our configuration
        if(!array_key_exists($file_ext, $file_ext_config)){
            echo "Unsupported file extension.";
        } else {
            // checking file size
            // check accepted file size in 'php.ini' file as well. search 'max_file_size'
            $max_file_size = 2 * 1024 * 1024; // 2MB File Size
            if($file_size > $max_file_size){
                echo "Please upload file less than 2MB.";
            } else {
                // checking file type
                if(!in_array($file_type, $file_ext_config)){
                    echo "Please upload image file only.";
                } else {
                    // checking file existence
                    if(!file_exists("uploads/$file_name")){
                        // upload file
                        if(move_uploaded_file($file_tmp_name, $upload_file_target)){
                            // taking user data from $_REQUEST
                            // $_REQUEST -> it takes data from $_GET, $_POST and $_COOKIE
                            $full_name = $_REQUEST['full_name'];
                            $email = $_REQUEST['email'];
                            $file_url = "uploads/$file_name";
                            saveUserFile($connect, $full_name, $email, $file_url);

                            echo "File uploaded successfully.<br>";
                        } else {
                            echo "Something went wrong while uploading. Please try again.";
                        }
                    } else {
                        echo "File $file_name already exist. Try again.";
                    }
                }
            }
        }
    } else {
        echo "Error: Something went wrong. {$_FILES['file_to_upload']['error']}";
    }
} else {
    echo "Not allowed. Go back <a href='index.php'>Click</a>";
}