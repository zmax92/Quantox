<?php
    require 'vendor/autoload.php';
    use App\QueryStudent;

    if(!empty($_GET['student'])) {
        $res = (new QueryStudent())->findStudent( $_GET['student'] );

        print '<pre>'.print_r($res, 1).'</pre>';
    }
    else {
        print 'missing student ID';
    }

?>