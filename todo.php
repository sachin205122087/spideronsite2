<?php
    include 'config.php';

    session_start();
    
    error_reporting(0);

    $pdo = new PDO("mysql:host=localhost;dbname=spider;charset=utf8","root","");

    if(isset($_POST['submit']) ){
        $name = $_POST['name'];
        $sth = $pdo->prepare("INSERT INTO todos (name) VALUES (:name)");
        $sth->bindValue(':name', $name, PDO::PARAM_STR);
        $sth->execute();
    }elseif(isset($_POST['delete'])){
        $id = $_POST['id'];
        $sth = $pdo->prepare("delete from todos where id = :id");
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    }
?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
    <title>Todo List</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>

<body class="container">
    <a class="btn" href="logout.php">logout</a>
    <h1>Todo List</h1>
    <form method="post" action="">
        <input type="text" name="name" value="">
        <input type="submit" name="submit" value="Add">
    </form>
    <h2>Current Todos</h2>
    <table class="table table-striped">
        <therad><th>Task</th><th></th></therad>
        <tbody>
<?php
    $sth = $pdo->prepare("SELECT * FROM todos ORDER BY id DESC");
    $sth->execute();
    
    foreach($sth as $row) {
?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>
                    <form method="POST">
                        <button type="submit" name="delete">Delete</button>
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="hidden" name="delete" value="true">
                    </form>
                </td>
            </tr>
<?php
    }
?>
        </tbody>
    </table>
</body>
</html>