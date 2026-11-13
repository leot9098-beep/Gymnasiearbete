<?php

require_once 'db.php';

function insertpost($message, $localuser, $userid)
{
    global $db;

    $sql = "INSERT INTO Imageboard
            (message, ip, uid)
            VALUES (:msg, :ip, :uid)";


    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':msg', $message);
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
        return 24;
    }

    $stmt = $db->prepare(
        'SELECT uid FROM Users WHERE username = :username LIMIT 1'
    );
    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? (int) $user['uid'] : 24;
}

function getUserIDAlt($username)
{
    global $db;

    $stmt = $db->prepare(
        "SELECT uid FROM Users WHERE username = :username LIMIT 1"
    );

    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? (int) $user['uid'] : 24;
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
    return $stmt;
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
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashed_password,
            ':ip' => $ip,
            ':uid' => $uid,
        ]);
    } catch (Exception $e) {
        die($e->getMessage());
    }
    return $stmt;
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

/*function getuserinfo($userid)
{
    $sql = "select * from Users where uid = :uid";

    global $db;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', $userid);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}*/

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

function isBanned($uid)
{
    global $db;
    $sql = "SELECT banneduntil FROM `Users`
        WHERE uid = :uid";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', $uid);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $banneduntil = $result['banneduntil'];
        if ($banneduntil !== null && strtotime($banneduntil) > time()) {
            return true;
        }
    } else {
        return false;
    }
}

function getBanReason($uid)
{
    global $db;
    $sql = "SELECT banreason FROM `Users`
        WHERE uid = :uid";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', $uid);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['banreason'];
    } else {
        return null;
    }
}

function getBanExpiry($uid)
{
    global $db;
    $sql = "SELECT banneduntil FROM `Users`
        WHERE uid = :uid";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', $uid);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['banneduntil'];
    } else {
        return null;
    }
}

function getStoredUserIP($uid)
{
    global $db;
    $sql = "SELECT ip FROM `Users`
        WHERE uid = :uid";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':uid', $uid);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['ip'];
    } else {
        return null;
    }
}

function banUser($uid, $reason, $expiry)
{
    global $db;
    $sql = "UPDATE `Users` SET banreason = :reason, banneduntil = :expiry WHERE uid = :uid";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reason', $reason);
    $stmt->bindValue(':expiry', $expiry);
    $stmt->bindValue(':uid', $uid);
    return $stmt->execute();
}

function getMembers()
{

    $sql = "SELECT Users.username, Users.created_at FROM Users ORDER BY Users.created_at DESC";

    global $db;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function getAvatar($uid)
{
    global $db;

    $stmt = $db->prepare(
        "SELECT pfp FROM Users WHERE uid = :uid LIMIT 1"
    );

    $stmt->execute([':uid' => $uid]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    return $user ? $user['pfp'] : null;
}

function uploadToGallery($filename, $filetype, $ip, $uid)
{
    global $db;

    $sql = "INSERT INTO Gallery
            (filetype, filename, pip, uid, related, upvoters, downvoters, reactions, tags)
            VALUES (:filetype, :filename, :pip, :uid, :related, :upvoters, :downvoters, :reactions, :tags)";


    try {
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':filetype', $filetype);
        $stmt->bindValue(':filename', $filename);
        $stmt->bindValue(':pip', $ip);
        $stmt->bindValue(':uid', $uid);
        $stmt->bindValue(':related', json_encode([]));
        $stmt->bindValue(':upvoters', json_encode([]));
        $stmt->bindValue(':downvoters', json_encode([]));
        $stmt->bindValue(':reactions', json_encode([]));
        $stmt->bindValue(':tags', json_encode([]));

        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        die("Forum insert failed: " . $e->getMessage());
    }
}

function getGalleryImages()
{
    $sql = "SELECT Gallery.pid, Gallery.filename, Gallery.description, Gallery.title, Gallery.time, Gallery.uid, `Users`.username FROM Gallery LEFT JOIN `Users` ON Gallery.uid = `Users`.uid ORDER BY Gallery.time DESC";

    global $db;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function timeAgo(string $time): string
{
    $timestamp = strtotime($time);

    if ($timestamp === false) {
        return $time; // Fallback if the date is invalid
    }

    $seconds = max(0, time() - $timestamp);

    if ($seconds < 60) {
        return 'just now';
    }
    if ($seconds < 3600) {
        $minutes = (int) floor($seconds / 60);
        return $minutes . ' min' . ($minutes === 1 ? '' : 's') . ' ago';
    }
    if ($seconds < 86400) {
        $hours = (int) floor($seconds / 3600);
        return $hours . ' hour' . ($hours === 1 ? '' : 's') . ' ago';
    }

    $days = (int) floor($seconds / 86400);
    return $days . ' day' . ($days === 1 ? '' : 's') . ' ago';
}
