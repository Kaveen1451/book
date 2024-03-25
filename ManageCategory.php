<?php
include ("BO/Config.php");
include("BO/Category.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Book category</title>
    <script>
        function addMore()
        {
            var tb = document.getElementById("tbCat");
            var tbody = tb.children[0];                                          //table body section
            tbody.insertBefore(tb.rows[1].cloneNode(true),                     //insert the another raw before the 2nd row
                    tb.rows[2]);
            
        }
        function Remove()
        {
            var tb = event.target.parentNode;
            var tr = tb.parentNode;                                         //tr is the parent(because tb is inside the tr then tb is child)
            tr.parentNode.removeChild(tr);
        }

    </script>
</head>
<body>
    
<aside>
    <?php
    if(isset($_POST["btnEdit"]))
    {
        $catEdit = category::GetCategory($_POST["btnEdit"]);
        $_SESSION["id"] = $_POST["btnEdit"];

    }
    ?>
    <form method="post" enctype="multipart/form-data">
    <table id="tbCat">
    <tr><td>Category</td>
    <td><input type="text" name="txtCat" id=""
    value="<?php
            if(isset($catEdit))
            echo $catEdit->getName();
    ?>"></td></tr>

    <tr><td>SubCategory</td>
    <td>
        <input type="text" name="txtSub[]" id="" value ="<?php 
                                                            if(isset($catEdit))
                                                            {
                                                              $sub2 = $catEdit->getSub();
                                                              if(sizeof($sub2)> 0)
                                                              echo $sub2[0][0];
                                                            }
                                                        ?>">
        <input type="button" value="Add another"
        onclick="addMore()">
        <input type="button" value="Remove"
        onclick="Remove()">
    </td>
    </tr>
    <?php
        if(isset($catEdit) && sizeof($sub2))
        {
            for($i=1;$i<sizeof($sub2);$i++)
            {
               echo ' <tr><td>SubCategory</td>
    <td>
        <input type="text" name="txtSub[]" id="" 
                            value ="'. $sub2[$i][0]
                                          .'"  >

        <input type="button" value="Add another"
        onclick="addMore()">
        <input type="button" value="Remove"
        onclick="Remove()">
    </td>
    </tr>';
            }
        }
    ?>
        
        <td>
            <tr>

            </tr>
        </td>
        
        <td>
        <input type="submit" value="Add Category" name="btnAdd">
        <input type="submit" value="Update Category" name="btnUpdate">
        <input type="submit" value="Delete Category" name="btnDelete">
        </td>

    </table>
        <?php
            if(isset($_POST["btnAdd"]))
        {
            try {
                $cat = new category();
                $cat->setName($_POST["txtCat"]);
                $cat->setSub($_POST["txtSub"]);
                $cid= $cat->Add();
                $cat->setID($cid);
                $subs= $cat->getSub();
                foreach($subs as $s)
                {
                    $cat->AddSubCategory($s);
                }
            
            } catch (Exception $er) {
                echo "Error".$er->getMessage();
            }
        }

        else if(isset($_POST["btnUpdate"])                                          //[update category]
                                            && isset($_SESSION["id"]))                               
        {
            try
            {
                $cat = new category();
                $cat->setName($_POST["txtCat"]);
                $cat->setSub($_POST["txtSub"]);
                $cat->setID($_SESSION["id"]);
                $cat->Update();
                $cat->DeleteSub();
                 $subs= $cat->getSub();
                foreach($subs as $s)
                {
                    $cat->AddSubCategory($s);
                }
            
            }
            catch(Exception $e)
            {
                echo "Error" .$er->getMessage();
            }
        }

        else if(isset ($_POST["btnDelete"])
                                            && isset($_SESSION["id"]))
        {
            try
            {
                $cat = new category();
                $cat->setID($_SESSION["id"]);
                $cat->DeleteSub();
                $cat->Delete();

            }
            catch(Exception $e)
            {
                echo "Error" .$er->getMessage();
            }

        }
        
        

?>
    </form>
</aside>
<main>
    <?php
        $cat = new category();
        $categories=$cat->GetCategories();
       if(sizeof($categories)>0)
       {
        echo '<form method="post"
         enctype="multipart/form-data">';

        echo'<table>';

        echo'<tr><th> ID</th>
                 <th> Name</th>
                <th> Sub Category</th>
                <th> Edit </th>
        </tr>';
        $r =0;
        foreach($categories as $cat)
        {
            echo'<tr>';
                echo'<td>'.$cat->getID().'</td>';
                echo'<td>'.$cat->getName().'</td>';
                echo'<td>';
                $sub = $cat->getSub();
               
                if(sizeof($sub) >0)
                {
                   
                    foreach($sub as $s)
                        echo $s[0].'<br>';
                }
                echo '</td>';
                echo '<td>
                     <button type= "submit" value= "' .$cat->GetID().
                    '" name="btnEdit">
            
                      Edit 
                      </button>

            

                    </td>';
            echo'</tr>';
        }

        echo'</table>';
        echo'</form>';
       }
    ?>
</main>

</body>
</html>