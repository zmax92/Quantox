<?php
    require 'vendor/autoload.php';
    use App\QueryStudent;

    if(!empty($_GET['student'])) {
        if(is_numeric($_GET['student'])) {
            $res = (new QueryStudent())->findStudent( $_GET['student'] );
    
            print $res;
        }
        else {
            print 'Student ID must be number';
        }
    }
    else {
        print 'Missing student ID';
    }

?>