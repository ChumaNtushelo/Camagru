<?php

include_once "./config/database.php";

session_start();

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$newemail = $_SESSION['mail'];
echo $newemail;

try {
    $conn = new PDO("mysql:host=$servername;dbname=camagru", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully(index.php)";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

    $query = "SELECT * FROM comments WHERE parent_comment_id = '0' ORDER BY comment_id DESC";

    $statement = $conn->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '';

    foreach($result as $row)
    {
        $output .= '<div class="panel panel-default">
                        <div class="panel-heading">By <b>' .$row["comment_sender_name"].'
                            </b> on <i>' .$row["date"].'</i></div>
                        <div class="panel-body">'.$row["comment"].'</div>
                        <div class="panel-footer" align="right"><button type="button"
                            class="btn btn-default reply" id"'.$row["comment_id"].'">
                            Reply</button></div>
                    </div>';
                    $output .= get_reply_comment($conn, $row["comment_id"]);
    }

    echo $output;

    function get_reply_comment($conn, $parent_id = 0, $marginleft = 0)
    {
        $query = "SELECT * FROM comments WHERE parent_comment_id = '".$parent_id."'";
        $statement = $conn->prepare($query);
        $statement->execute();
        $result = $statement->fetchALL();
        $count = $statement->rowCount();
        if($parent_id == 0)
        {
            $marginleft = 0;
        }
        else
        {
            $marginleft = $marginleft + 48;
        }
        if($count > 0)
        {
            foreach($result as $row)
            {
                $output .= '
                <div class="panel panel-default" style="margin-left:'.$marginleft.'px">
                    <div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i></div>
                    <div class="panel-body">'.$row["comment"].'</div>
                    <div class="panel-footer" align="right"><button
                        type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
                    </div>
                    ';
                    $output .= get_reply_comment($conn, $row["comment_id"], $marginleft);
            }
        }
        return $output;
    }