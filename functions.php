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
        "SELECT uid FROM Users WHERE username = :username LIMIT 1"
    );

    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? (int) $user['uid'] : null;
}

function getUserIDAlt($username)
{
    global $db;

    $stmt = $db->prepare(
        "SELECT uid FROM Users WHERE username = :username LIMIT 1"
    );

    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? (int) $user['uid'] : null;
}


function getForumPosts()
{

    $sql = "SELECT Imageboard.message, Imageboard.time, Imageboard.uid, `Users`.username FROM Imageboard LEFT JOIN `Users` ON Imageboard.uid = `Users`.uid ORDER BY Imageboard.time DESC";

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
    $sql = "SELECT * FROM `Users`
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
        "SELECT password_hash FROM Users WHERE uid = :uid LIMIT 1"
    );

    $stmt->execute([':uid' => $userid]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? $user['password_hash'] : null;
}

function addUser($username, $hashed_password, $ip)
{
    global $db;

    $sql = "INSERT INTO `Users` (`username`, `password_hash`, `ip`)
        VALUES (:username, :password_hash, :ip)";

    $stmt = $db->prepare($sql);

    try {
        $stmt->execute([
            ':username' => $username,
            ':password_hash' => $hashed_password,
            ':ip' => $ip,
        ]);
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function updateUser($username, $hashed_password, $ip, $uid)
{

    global $db;
    $sql = "UPDATE `Users` SET username = :username, password_hash = :password, ip = :ip WHERE uid = :uid";


    $stmt = $db->prepare($sql);

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $hashed_password);
    $stmt->bindValue(':ip', $ip);
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
    $sql = "select * from Users where uid = :uid";

    global $db;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', $userid);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function searchUserPost($search)
{
    global $db;

    $sql = "SELECT Imageboard.message, Imageboard.time, Imageboard.uid, `Users`.username FROM Imageboard LEFT JOIN `Users` ON Imageboard.uid = `Users`.uid WHERE message LIKE :search ORDER BY Imageboard.time DESC";

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();

    return $stmt;
}

function searchUserPostByID($search)
{
    global $db;

    $sql = "SELECT Imageboard.message, Imageboard.time, Imageboard.uid, `Users`.username FROM Imageboard LEFT JOIN `Users` ON Imageboard.uid = `Users`.uid WHERE Imageboard.uid = :uid ORDER BY Imageboard.time DESC";


    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', (int) $search, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt;
}
