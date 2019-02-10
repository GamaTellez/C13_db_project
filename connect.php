<?php
    $user='cmdogyejtrjlwy';
    $pass='b334c4d6cfc3050fd19f76610f866b6d46041ded56f79f922314a4605d01e2f1';
    $tdb='d8acrfr8271cc';

    $db = new mysqli('localhost', $user, $pass, $tdb) or die("Unable to connect");

    echo "it works!!";
?>