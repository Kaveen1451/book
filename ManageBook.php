<?php
include ("BO/Config.php");
include ("BO/Book.php");
include("BO/Category.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Books</title>

    <script>
        function LoadSubs()
        {

            try {
               
              
               var  httpxml = new XMLHttpRequest();
            
               var catID = document.getElementById("ddCat").value;
             
              var url ="LoadSub.php?catID="+catID;//LOadSub is the php folder AND CatID IS THE paRAMETIER
             
              httpxml.onreadystatechange=Check;//the function below "Check"
               
             httpxml.open("GET",url,true);
              httpxml.send(null);

            } catch (error) {
               
            }
            function Check()
            {
                if(httpxml.readyState == 4)//getting the respons
                {
                    var subs= JSON.parse(httpxml.responseText);//respons text contain subcategories fetching/getting the sting on loadsub to here 
                    for(k=document.bookdata.ddSubCat.options.length-1;k>=0;k--)/*documant= htmlfile,bookdata=name of the form ,ddSubCat =subcategoryis,
                options= the options the subcategory has,length-1;k>=0;k-- = condition*/
                {
                    document.bookdata.ddSubCat.remove(k);
                }
                for(i=0;i<subs.length;i++)
                {
                    var optn=document.createElement("OPTION");//crating a element called option (becz there options inside the select)
                    optn.text= subs[i][0];//the postion of the sub
                    document.bookdata.ddSubCat.options.add(optn);
                }          
            }
            }
        }
    </script>

</head>
<body>
    <form method="post" enctype="multipart/form-data" name="bookdata">
    <table>
<?php
    if(isset($_GET["btnEdit"]))
    {
      $book = new Book();
      $book->setBID($_GET["btnEdit"]);
      $book = $book->GetBook();

    }
    ?>
<tr><td>Book ID</td>
<td><input type="number" readonly name="txtID" value="<?php
                                                                                                                     if(isset($book)) 
                                                                                                                     echo $book->getBID();
                                                                                                                  
                                                                                                                  ?>">
            </div>></td></tr>

<tr><td>Title</td>
<td><input type="text"  name="txtTitle" required></td></tr>

<tr><td>Author</td>
<td><input type="text"  name="txtAuthor" required></td></tr>

<tr><td>Select Category</td>

<td><select name="ddCat" id="ddCat" onchange="LoadSubs()" >

                <?php
                $cat = new category();
                $list =$cat->GetCategories();           //in this we added all categories to the book.php
                echo '<option> select category</option>';
                foreach($list as $c)

                {
                    echo '<option value="'.$c->getId().'">'.$c->getName(). '</option>';
                }
                ?>

</select></td></tr>
<tr><td>Select SubCategory</td>
<td><select name="ddSubCat" id="ddSubCat">
    
</select></td></tr>

<tr><td>ISBN</td>
<td><input type="text"  name="txtISBN"></td></tr>

<tr><td>Description</td>
<td><textarea name="txtDes" id="" cols="30" rows="5"></textarea></td></tr>

<tr><td>FullDiscription</td>
<td><textarea name="txtFullDes" id="" cols="30" rows="10"></textarea></td></tr>

<tr><td>FrontCover</td>
<td><input type="file"  name="txtCoverFront" id=""></td></tr>

<tr><td>BackCover</td>
<td><input type="file"  name="txtCoverBack" id=""></td></tr>

<tr><td>Price</td>
<td><input type="number"  name="txtPrice"></td></tr>


<td>
        <input type="submit" value="Add Book" name="btnAdd">
        <input type="submit" value="Update Book" name="btnUpdate">
        <input type="submit" value="Delete Book" name="btnDelete">
        </td>


    </table>
   
    </form>
    <?php
    if(isset($_POST["btnAdd"]))
    {
        $book = new book();
        $book->setTitle($_POST["txtTitle"]);
        $book->setAuthor($_POST["txtAuthor"]);
        $book->setCategory($_POST["ddCat"]);
        $book->setSubCategory($_POST["ddSubCat"]);
        $book->setISBN($_POST["txtISBN"]);
        $book->setDescription($_POST["txtDes"]);
        $book->setFullDiscription($_POST["txtFullDes"]);
        $book->setPrice($_POST["txtPrice"]);

            try {
                $id= $book->Add();                                                      //we add book id
                $front = $_FILES["txtCoverFront"]['name'];                               // in this we add file
                $info = new SplFileInfo($front);                                        // we can add deteils about that file
                $newFront = './BookCover/'.$id.'F.'.$info->getExtension() ;              //in this we create new file and location where we create a file
                $book->SetCoverFront($newFront);
                $book->setBID($id);
                move_uploaded_file($_FILES["txtCoverFront"]['tmp_name'],$newFront);     // in this move file from tempory location to new location
                $book->UpdateFrontCover();
                //backCover
                $back = $_FILES["txtCoverBack"]['name'];                               //this is backcover details
                $info = new SplFileInfo($back);                                        
                $newBack = './BookCover/'.$id.'B.'.$info->getExtension() ;           
                $book->SetCoverBack($newBack);
                move_uploaded_file($_FILES["txtCoverBack"]['tmp_name'],$newBack);     
                $book->UpdateBackCover();
                echo "Book Added";


            } catch (Exception $th) {
                echo  $th->getMessage();
            }


    }
    
     
        $book = new book();
        $books=$book->GetBooks();
      
       if(sizeof($books)>0)
       {
        echo '<form method="post"  enctype= "multipart/form-data">';

        echo'<table>';

        echo'<tr><th> BID</th>
                 <th> Title</th>
                <th> Author</th>
                <th> Category</th>
                <th> SubCategory</th>
                <th> ISBN</th>
                <th> Discription</th>
                <th> FullDiscription</th>
                <th> Coverfront</th>
                <th> CoverBack</th>
                <th> Price</th>
                <th> Edit </th>
        </tr>';
        $r =0;
        foreach($books as $book)
        {
            echo'<tr>';
            echo'<td>'.$book->getBID().'</td>';
            echo'<td>'.$book->getTitle().'</td>';
            echo'<td>'.$book->getAuthor().'</td>';
            echo'<td>'.$book->getCategory().'</td>';
            echo'<td>'.$book->getSubCategory().'</td>';
            echo'<td>'.$book->getISBM().'</td>';
            echo'<td>'.$book->getDescription().'</td>';
            echo'<td>'.$book->getFullDiscription().'</td>';
            echo'<td>'.$book->getCoverFront().'</td>';
            echo'<td>'.$book->getCoverBack().'</td>';
            echo'<td>'.$book->getprice().'</td>';

            echo '</td>';
            echo '</td>';
                echo '<td>
                     <button type= "submit" value= "' .$book->getBID().
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
</body>
</html>