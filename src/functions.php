<?php
function login($username, $password) {
     // Our database object
    $db = new Db();
    // Quote and escape form submitted values
    $name = $db -> quote($username);
    $pass = $db -> quote($password);
    $rows = $db -> select("SELECT `user`,`pass`,`salt` FROM `user` WHERE `user`=".$name);

    if($rows[0][pass]==$password){
        $_SESSION['username'] = $username;
        return true;
    }
    else
        return false;

}


function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

?>
