<?php
function getNext($inputChar)
{
$next_Char=++$inputChar;
if(strlen($next_Char)>1)
{
   $next_Char=$next_Char[0];


}
echo"$next_Char";
}
getNext(1);


function getLastSlash($url)
{
//$splitUrl=str_split('/');
$pos=strrpos($url,"/");

$last=substr($url,++$pos);
echo"$last";

}

getLastSlash('http//www.example.com/5478631');

?>