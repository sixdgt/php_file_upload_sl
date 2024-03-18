<?php
function displayUserFile(){     
    $connect = mysqli_connect("localhost", "sixdgt", "1234", "test_file_upload");

    $sql = "SELECT * FROM test_user_files";

    $res_data = mysqli_query($connect, $sql);

    $user_data = array();

    if(mysqli_num_rows($res_data) > 0){
        while($row = mysqli_fetch_array($res_data)){
            $user_data[] = array(
                "full_name" => $row['full_name'],
                "email" => $row['email'],
                "file_url" => $row['file_url'],
            );
        }
    }

    return $user_data;
}
