<?php
ob_start();
session_start();

if (isset($_POST['chat-input'])) {
    $message = $_POST['chat-input'];

    $db = new PDO('sqlite:database.db');

    require("../../../lang/lang.php");
    $strings = tr();

    if ($_SESSION['authority'] == "user") {
        $session = "admin";
    } elseif ($_SESSION['authority'] == "admin") {
        $session = "user";
    }

    if (filter_var($message, FILTER_VALIDATE_URL)) {
        $url = $message;
        $parts = parse_url($url);
        $query = array();

        error_reporting(0);

        parse_str($parts['query'], $query);

        if (isset($query['new_password']) && isset($query['confirm_password'])) {
            if ($query['new_password'] == $query['confirm_password']) {
                $insert = $db->prepare("UPDATE csrf_changing_password SET password=:password WHERE authority=:authority");
                $status_insert = $insert->execute(array(
                    'authority' => $session,
                    'password' => $query['new_password']
                ));
            }
        }
    }

    $insert_s = $db->prepare('INSERT INTO csrf_chat (authority, message) VALUES (:authority, :message)');
    $insert_s->execute(array(
        'authority' => $_SESSION['authority'],
        'message' => $message
    ));

    $message_reply = $strings['message_reply'];
    $insert_r = $db->prepare('INSERT INTO csrf_chat (authority, message) VALUES (:authority, :message)');
    $insert_r->execute(array(
        'authority' => $session,
        'message' => $message_reply
    ));

    $select = $db->prepare("SELECT * FROM csrf_chat ORDER BY id DESC");
    $select->execute();
    $db_messages = $select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($db_messages as $db_message) {
        if ($_SESSION['authority'] == "user") {
            if ($db_message['authority'] == "user") {
                echo '<div class="messages__item messages__item--operator">' . $db_message['message'] . '</div>';
            }
            if ($db_message['authority'] == "admin") {
                echo '<div class="messages__item messages__item--visitor">' . $db_message['message'] . ' <pre class="m-0 mt-1 text-danger">admin</pre> </div> ';
            }
        }

        if ($_SESSION['authority'] == "admin") {
            if ($db_message['authority'] == "admin") {
                echo '<div class="messages__item messages__item--operator">' . $db_message['message'] . '</div>';
            }
            if ($db_message['authority'] == "user") {
                echo '<div class="messages__item messages__item--visitor">' . $db_message['message'] . '<pre class="m-0 mt-1 text-danger">user</pre></div> ';
            }
        }
    }
} else {
    header("Location: index.php");
    exit;
}
?>
