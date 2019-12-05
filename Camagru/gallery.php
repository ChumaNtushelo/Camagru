<?php
include_once "config/database.php";

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

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

// user input
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = isset($_GET['per-page']) && $_GET['per-page'] <= 50 ? (int)$_GET['per-page'] : 5;

// positioning
$start = ($page > 1) ? ($page * $perPage) - $perPage : 0;

// query fetching from the database
$articles = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM gallery LIMIT {$start}, {$perPage}");
$articles->execute();
$articles = $articles->fetchAll(PDO::FETCH_ASSOC);

// pages
$total = $conn->query("SELECT FOUND_ROWS() as total")->fetch()['total'];
$pages = ceil($total / $perPage);


$error = '';
$comment_name = '';
$comment_content = '';

if(empty($_POST["comment_name"]))
{
    $error .= '<p class="text-danger">Name is required</p>';
}
else
{
    $comment_name = $_POST["comment_name"];
}

if(empty($_POST["comment_content"]))
{
    $error .= '<p class="text-danger">Comment is required</p>';
}
else
{
    $comment_contnet = $_POST["comment_content"];
}

if($error == '')
{
    $query = "INSERT INTO commentstable (parent_comment_id, doment, comment_sender_name) VALUES (:parent_comment_id, :comment, :comment_sender_name)";
    $statement = $conn->prepare($query§);
    $statement->execute(array(':parent_comment_id' =>'0', ':comment' => $comment_content, ':comment_sender_name' => $comment_name));

    $error = '<label class="text-success">Comment Added</label>';
}

$data = array('error' => $error);

echo json_encode($data);
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="style.css">
            <title> Gallery </title>
    </head>
        <body>
        <header>
            <nav>
                <div class="main-wrapper">
                    <ul>
                        <h1> Camagru </h1>
                    </ul>

                </div>
                <a href="home.php"> Home </a> |
                <a href="profile.php"> Profile </a> |
                <a href="logout.php" class="logout"> logout</a>
            </nav>
        </header>
            <hr>

        <?php foreach($articles as $article): ?>
                <div class="article">
                        <p><?php echo $article['id']; ?>: <?php echo $article['imagename']; ?></p>
                </div>
                <img src=<?php echo("uploads/".$article['imagename']); ?> style="height: 150px; width: 200px;"  alt="image">
                <br/>
                <a href="like.php"> Like </a> | <a href=".php"> Unlike </a> | <a href="delete.php"> Delete </a>
                <br/>
                <div>
                    <textarea cols="36" rows="3" placeholder="Comment"></textarea>
                    <br/>
                    <br/>
                    <input type="submit" name="submit" value="Add Comment" />
                </div>
                <!-- <div class="comment">
                    <div class="user">user  vbn</div>
                    <div class="userComment">this is my comment</div>
                    <div class="replies">its a reply</div>
                </div> -->
        <?php endforeach; ?>

        <div class="pagination">
        <?php for($x = 1; $x <= $pages; $x++): ?>
                <a href="?page=<?php echo $x; ?>&per-page=<?php echo $perPage; comm?>"><?php echo $x; ?></a>
        <?php endfor; ?>
                </div>
        </body>
    <footer style="float: right;"> Camagru &copy cntushel 2019 </footer>
</html>

<script>
$(document).ready(function(){

    $('#comment_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"add_comment.php";
            method:"POST",
            data:form_data,
            dataType:"JSON",
            success:function(data)
            {
                if(data.error != '')
                {
                    $('#comment_form')[0].reset();
                    $('#comment_message').html(data.error);
                }
            }
        })
    })

    load_comment();

    function load_comment()
    {
        $.ajax({
            url:"fetch_comment.php",
            method:"POST",
            success:function(data)
            {
                $('#display_comment').html(data);
            }
        })
    }

    $(document).on('click', '.reply', function(){
        var comment_id = $(this).attr("id");
        $('#comment_id').val(comment_id);
        $('#comment_name').focus();
    });
});
</script>