<?php
//
@$catID = $_GET['catID'];//getting the  catid as a pramiter by capturing it by@
if(!is_numeric(($catID)))//cheking wheter it is a number
{
    echo "Data Error";
    exit;
}
include("BO/Config.php");
include("BO/Category.php");

$cat = new category;
$cat-> setID($catID);//setting the cat as catid that we created above
$subs=$cat->getSubCategories();
echo json_encode($subs);//converting the obj to a string obj by using json encode
?>