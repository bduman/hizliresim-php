<?php
require_once '../class/hizliresim.class.php';

$hizliResim = new Hizliresim(true);

$single = $hizliResim->upload("http://materializecss.com/images/starter-template.gif");

echo "<pre>";

var_dump($single);