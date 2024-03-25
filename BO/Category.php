<?php

//include("Config.php");
class category
{
    private $Id;
    private $Name;
    private $SubCategory=array();

    public function setID($id)
    {
        $this->Id= $id;
    }

    public function setName($name)
    {
        $this->Name= $name;
    }

    public function setSub($sub)
    {
        $this->SubCategory= $sub;
    }

    public function getId()
    {
        return $this->Id;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getSub()
    {
        return $this->SubCategory;
    }

    public function Add()
    {
        try {
            $conn= Config::GetConnection();                                      //create connection
            $query ="INSERT INTO `category`( `Name`) VALUES (?)";               //mark paramiter
            $stmt=$conn->prepare($query);                                       // prepare the query
            $stmt->bindParam(1,$this->Name,PDO::PARAM_STR);                      //paramiter number,value,data base
            $stmt->execute();                                                    //run the query
             return $conn->lastInsertId();                                       //last record id pz return  
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function AddSubCategory($sub)                                    //add the $sub beuase of array
    {
        try {
            $conn= Config::GetConnection();                             
            $query ="INSERT INTO `subcategory`(`CID`, `SubCategory`) VALUES (?,?)";    
            $stmt=$conn->prepare($query);                       
            $stmt->bindParam(1,$this->Id,PDO::PARAM_INT);                    //PARAM_INT(int)
            $stmt->bindParam(2,$sub,PDO::PARAM_STR);
            $stmt->execute();                                    
                                  
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    public function GetCategories()
    {
        try
        {
            $conn= Config::GetConnection();
            $query= "SELECT `ID`, `Name` FROM `category`";
            $result= $conn->query($query);
            $Categories=array();
            foreach($result as $r)
            {
                $cat = new category();
                $cat->setID($r[0]);
                $cat->setName($r[1]);
                $cat->setSub($cat->getSubCategories());
                array_push($Categories,$cat);
            }
            return $Categories;

        }
        catch(Exception $e)
        {
            throw $e;
        }
    }
    public function getSubCategories()
    {
        try
        {
            $conn = Config::GetConnection();
            $query= "SELECT  `SubCategory` 
                        FROM `subcategory` WHERE `CID`= ?";
            $stmt= $conn->prepare($query);
            $stmt->bindParam(1,$this->Id,PDO::PARAM_INT);
            $stmt->execute();
            $res= $stmt->fetchAll();
            return $res;
        }
        catch (Exception $e)
        {
            throw $e;
        }
    }
    public function Update()
    {
        try {
            $conn= Config::GetConnection();                                     
            $query ="UPDATE `category`
                     SET `Name`=? 
                     WHERE `ID`=?";              
            $stmt=$conn->prepare($query);                                       
            $stmt->bindParam(1,$this->Name,PDO::PARAM_STR);  
            $stmt->bindParam(2,$this->Id,PDO::PARAM_INT);                
            $stmt->execute();                                                    
                                                     
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    public function Delete()
    {
        try {
            $conn= Config::GetConnection();                                     
            $query ="Delete from `category`
                      WHERE `ID`=?";              
            $stmt=$conn->prepare($query);                                         
            $stmt->bindParam(1,$this->Id,PDO::PARAM_INT);                
            $stmt->execute();                                                    
                                                     
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    public function DeleteSub()
    {
        try {
            $conn= Config::GetConnection();                                     
            $query ="Delete from  `subcategory`
                      WHERE `CID`=?";              
            $stmt=$conn->prepare($query);                                         
            $stmt->bindParam(1,$this->Id,PDO::PARAM_INT);                
            $stmt->execute();                                                    
                                                     
            
        } catch (Exception $ex) {
            throw $ex;
        }
    }
    public static function GetCategory($Id)
    {
        try
        {
            $conn= Config::GetConnection();
            $query= "SELECT `ID`, `Name` FROM `category`
            where ID=?";
            $stmt= $conn->prepare($query);
            $stmt->bindParam(1,$Id,PDO::PARAM_INT);
            $stmt->execute();
            $r= $stmt->fetchAll();
             $cat = new category();
                $cat->setID($r[0][0]);
                $cat->setName($r[0][1]);
                $cat->setSub($cat->getSubCategories());
                return $cat;
            
            

        }
        catch(Exception $e)
        {
            throw $e;
        }
    }
    

}


?>