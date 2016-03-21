<?php
require_once '../class/hizliresim.class.php';

$hizliResim = new Hizliresim();

$multi = $hizliResim->upload(array(
    "http://materializecss.com/images/parallax-template.jpg",
    "http://materializecss.com/images/starter-template.gif"
));

echo "<pre>";

var_dump($multi);
