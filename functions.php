<?php

require_once 'config/db.php';

function insertForumpost($message, $localuser, $userid)
{
    global $forum;

    $sql = "INSERT INTO forum
            (message, localuser, uid)
            VALUES (:msg, :ip, :uid)";

    $roll = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ' OOOY DOCTOOOOSSSS!!!!', ' or something.', ' o algo.', ' grrrrr.', ' shit jari cares about.', ' slop.', ' döda integram.', ' fugging leo...', ' how could you tell.', ' 67 tuff.', ' jag är en vivaldi traiso wompa btw.', ' jag är trans btw.',);
    $messageroll = $roll[array_rand($roll)];

    try {
        $stmt = $forum->prepare($sql);

        $stmt->bindValue(':msg', $message . $messageroll);
        $stmt->bindValue(':ip', $localuser);
        $stmt->bindValue(':uid', $userid);

        $stmt->execute();

        updatePostcount($userid);
        return true;
    } catch (PDOException $e) {
        die("Forum insert failed: " . $e->getMessage());
    }
}

function getUserID()
{
    global $forum;

    $username = $_SESSION['username'] ?? null;

    if (!$username) {
        return null;
    }

    $stmt = $forum->prepare(
        "SELECT uid FROM user WHERE username = :username LIMIT 1"
    );

    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? (int) $user['uid'] : null;
}

function getUserIDAlt($username)
{
    global $forum;

    $stmt = $forum->prepare(
        "SELECT uid FROM user WHERE username = :username LIMIT 1"
    );

    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? (int) $user['uid'] : null;
}


function getForumPosts()
{

    $sql = "SELECT forum.message, forum.time, forum.uid, `user`.username FROM forum LEFT JOIN `user` ON forum.uid = `user`.uid ORDER BY forum.time DESC";

    global $forum;
    $stmt = $forum->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function login($username, $password)
{
    global $forum;
    $userid = getUserIDAlt($username);
    $hashed_password = getPass($userid);
    $sql = "SELECT * FROM `user`
        WHERE username = :username
        AND password = :password";
    $stmt = $forum->prepare($sql);
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
    global $forum;

    $stmt = $forum->prepare(
        "SELECT password FROM user WHERE uid = :uid LIMIT 1"
    );

    $stmt->execute([':uid' => $userid]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? $user['password'] : null;
}

function addUser($username, $name, $hashed_password, $localuser)
{
    global $forum;

    $sql = "INSERT INTO `user`
            (username, name, password, localuser)
            VALUES (:username, :name, :password, :localuser)";

    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':password', $hashed_password);
    $stmt->bindValue(':localuser', $localuser);

    try {
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

function updateUser($username, $name, $hashed_password, $localuser, $uid)
{

    global $forum;
    $sql = "UPDATE `user` SET username = :username, name = :name, password = :password, localuser = :localuser WHERE uid = :uid";


    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':password', $hashed_password);
    $stmt->bindValue(':localuser', $localuser);
    $stmt->bindValue(':uid', $uid);

    try {
        return $stmt->execute();
    } catch (Exception $e) {
        return false;
    }
}

function updatePostcount($userid)
{
    global $forum;

    $sql = "UPDATE `user`
            SET postcount = COALESCE(postcount, 0) + 1
            WHERE uid = :uid";

    $stmt = $forum->prepare($sql);

    $stmt->bindValue(':uid', $userid);

    return $stmt->execute();
}

function getuserinfo($userid)
{
    $sql = "select * from user where uid = :uid";

    global $forum;
    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':uid', $userid);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function searchUserPost($search)
{
    global $forum;

    $sql = "SELECT forum.message, forum.time, forum.uid, `user`.username FROM forum LEFT JOIN `user` ON forum.uid = `user`.uid WHERE message LIKE :search ORDER BY forum.time DESC";

    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();

    return $stmt;
}

function searchUserPostByID($search)
{
    global $forum;

    $sql = "SELECT forum.message, forum.time, forum.uid, `user`.username FROM forum LEFT JOIN `user` ON forum.uid = `user`.uid WHERE forum.uid = :uid ORDER BY forum.time DESC";


    $stmt = $forum->prepare($sql);
    $stmt->bindValue(':uid', (int) $search, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt;
}
