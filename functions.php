<?php

require_once 'db.php';

function insertpost($message, $localuser, $userid)
{
    global $db;

    $sql = "INSERT INTO Imageboard
            (message, ip, uid)
            VALUES (:msg, :ip, :uid)";

    //$roll = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ' OOOY DOCTOOOOSSSS!!!!', ' or something.', ' o algo.', ' grrrrr.', ' shit jari cares about.', ' slop.', ' döda integram.', ' fugging leo...', ' how could you tell.', ' 67 tuff.', ' jag är en vivaldi traiso wompa btw.', ' jag är trans btw.',);
    //$messageroll = $roll[array_rand($roll)];

    try {
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':msg', $message/* . $messageroll*/);
        $stmt->bindValue(':ip', $localuser);
        $stmt->bindValue(':uid', $userid);

        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        die("Forum insert failed: " . $e->getMessage());
    }
}

function getUserID()
{
    global $db;

    $username = $_SESSION['username'] ?? null;

    if (!$username) {
        return null;
    }

    $stmt = $db->prepare(
        "SELECT uid FROM users WHERE username = :username LIMIT 1"
    );

    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? (int) $user['uid'] : null;
}

function getUserIDAlt($username)
{
    global $db;

    $stmt = $db->prepare(
        "SELECT uid FROM users WHERE username = :username LIMIT 1"
    );

    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? (int) $user['uid'] : null;
}


function getForumPosts()
{

    $sql = "SELECT Imageboard.message, Imageboard.time, Imageboard.uid, `users`.username FROM Imageboard LEFT JOIN `users` ON Imageboard.uid = `users`.uid ORDER BY Imageboard.time DESC";

    global $db;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function login($username, $password)
{
    global $db;
    $userid = getUserIDAlt($username);
    $hashed_password = getPass($userid);
    $sql = "SELECT * FROM `users`
        WHERE username = :username
        AND password_hash = :password";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $hashed_password);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        return password_verify($password, $hashed_password);
    } else {
        return false;
    }
}

function getPass($userid)
{
    global $db;

    $stmt = $db->prepare(
        "SELECT password_hash FROM users WHERE uid = :uid LIMIT 1"
    );

    $stmt->execute([':uid' => $userid]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? $user['password_hash'] : null;
}

function addUser($username, $hashed_password, $localuser)
{
    global $db;

    $sql = "INSERT INTO `users`
            (username, password_hash, ip)
            VALUES (:username, :password, :localuser)";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $hashed_password);
    $stmt->bindValue(':localuser', $localuser);

    try {
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

function updateUser($username, $hashed_password, $localuser, $uid)
{

    global $db;
    $sql = "UPDATE `users` SET username = :username, password_hash = :password, ip = :localuser WHERE uid = :uid";


    $stmt = $db->prepare($sql);

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $hashed_password);
    $stmt->bindValue(':localuser', $localuser);
    $stmt->bindValue(':uid', $uid);

    try {
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

/*function updatePostcount($userid)
{
    global $db;

    $sql = "UPDATE `users`
            SET postcount = COALESCE(postcount, 0) + 1
            WHERE uid = :uid";

    $stmt = $db->prepare($sql);

    $stmt->bindValue(':uid', $userid);

    return $stmt->execute();
}*/

function getuserinfo($userid)
{
    $sql = "select * from users where uid = :uid";

    global $db;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', $userid);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function searchUserPost($search)
{
    global $db;

    $sql = "SELECT Imageboard.message, Imageboard.time, Imageboard.uid, `users`.username FROM Imageboard LEFT JOIN `users` ON Imageboard.uid = `users`.uid WHERE message LIKE :search ORDER BY Imageboard.time DESC";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();

    return $stmt;
}

function searchUserPostByID($search)
{
    global $db;

    $sql = "SELECT Imageboard.message, Imageboard.time, Imageboard.uid, `users`.username FROM Imageboard LEFT JOIN `users` ON Imageboard.uid = `users`.uid WHERE Imageboard.uid = :uid ORDER BY Imageboard.time DESC";


    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', (int) $search, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt;
}
