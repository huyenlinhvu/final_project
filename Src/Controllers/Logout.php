<?php
use Services\Session\Session;

Session::init();
// session_start();
// session_unset();

Session::end();
// session_destroy();


header('Location: index.php?url=homePage');