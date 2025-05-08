<?php  
function randomString($length)
{
    $str        = "";
    $characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZ123456789';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}
$kode = randomString(6); //hasil: yGei7kH3LMHvxaq


function randomString2($length)
{
    $str        = "";
    $characters = '0123456789';
    $max        = strlen($characters) - 1;
    for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
    }
    return $str;
}
$kodeguru = randomString2(6); //hasil: yGei7kH3LMHvxaq
?>