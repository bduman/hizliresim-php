<?php
require_once '../class/hizliresim.class.php';

$hizliResim = new Hizliresim();

$hizliResim->collect(array(
    "http://materializecss.com/images/starter-template.gif",
    "http://materializecss.com/images/starter-template.gif"
));

$hizliResim->collect("http://materializecss.com/images/parallax-template.jpg");

$collect = $hizliResim->go();

echo "<pre>";

var_dump($collect);