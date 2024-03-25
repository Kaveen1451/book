<?php
//include ("Config.php");
class book

{
    private $BID;
    private $Title;
    private $Author;
    private $Category;
    private $SubCategory;
    private $ISBN;
    private $Description;
    private $FullDiscription;
    private $CoverFront;
    private $CoverBack;
    private $Price;


    public function getBID()
        {
            $this->BID;
        }

    public function setBID($bid)
        {
            $this->BID= $bid;
        }

    public function getTitle()
        {
            $this->Title;
        }

    public function setTitle($title)
        {
            $this->Title= $title;
        }

    public function getAuthor()
        {
            $this->Author;
        }

    public function setAuthor($author)
        {
            $this->Author= $author;
        }

    public function getCategory()
        {
            $this->Category;
        }

    public function setCategory($category)
        {
            $this->Category= $category;
        }

    public function getSubCategory()
        {
            $this->SubCategory;
        }

    public function setSubCategory($Sub)
        {
            $this->SubCategory= $Sub;
        }

    public function getISBM()
        {
            $this->ISBN;
        }

    public function setISBN($isbn)
        {
            $this->ISBN= $isbn;
        }

    public function getDescription()
        {
            $this->Description;
        }

    public function setDescription($discription)
        {
            $this->Description= $discription;
        }

    public function getFullDiscription()
        {
            $this->FullDiscription;
        }

    public function setFullDiscription($fDiscription)
        {
            $this->FullDiscription= $fDiscription;
        }

    public function getCoverFront()
        {
            $this->CoverFront;
        }

    public function setCoverFront($cFront)
        {
            $this->CoverFront= $cFront;
        }

    public function getCoverBack()
        {
            $this->CoverBack;
        }


    public function setCoverBack($cBack)
        {
            $this->CoverBack= $cBack;
        }

    public function getprice()
        {
            $this->Price;
        }


    public function setPrice($price)
        {
            $this->Price= $price;
        }

        public function Add()

            {
                try {
                    $conn= Config::GetConnection();                                      
                    $query ="INSERT INTO `book`(`Title`, `Author`, `Category`, `SubCategory`, `ISBN`, `Description`, `FullDescription`, 
                     `Price`) 
                    VALUES (?,?,?,?,?,?,?,?)";               
                    $stmt=$conn->prepare($query);                                       
                    $stmt->bindParam(1,$this->Title,PDO::PARAM_STR);  
                    $stmt->bindParam(2,$this->Author,PDO::PARAM_STR);
                    $stmt->bindParam(3,$this->Category,PDO::PARAM_STR);
                    $stmt->bindParam(4,$this->SubCategory,PDO::PARAM_STR);  
                    $stmt->bindParam(5,$this->ISBN,PDO::PARAM_STR); 
                    $stmt->bindParam(6,$this->Description,PDO::PARAM_STR);
                    $stmt->bindParam(7,$this->FullDiscription,PDO::PARAM_STR);   
                    $stmt->bindParam(8,$this->Price,PDO::PARAM_INT);               
                    $stmt->execute();                                                    
                                    return $conn->lastInsertId();
                    
                } catch (Exception $th) {
                    throw $th;
                }
            }
        
        public function UpdateFrontCover()

            {
                try {
                    $conn= Config::GetConnection();                                      
                    $query ="UPDATE `book` SET CoverFront=? WHERE BID=?";               
                    $stmt=$conn->prepare($query);                                       
                    $stmt->bindParam(1,$this->CoverFront,PDO::PARAM_STR); 
                    $stmt->bindParam(2,$this->BID,PDO::PARAM_INT); 
                    $stmt->execute();
                    
                } catch (Exception $ex) {
                    throw $ex;
                }
            }

            public function UpdateBackCover()

            {
                try {
                    $conn= Config::GetConnection();                                      
                    $query ="Update book set CoverBack=? where BID=?";               
                    $stmt=$conn->prepare($query);                                       
                    $stmt->bindParam(1,$this->CoverBack,PDO::PARAM_STR); 
                    $stmt->bindParam(2,$this->BID,PDO::PARAM_INT); 
                    $stmt->execute();
                    
                } catch (Exception $ex) {
                    throw $ex;
                }
            }


            public function GetBooks()

            {
                try {
                    
                    $conn= Config::GetConnection();
                    $query= "SELECT `BID`, `Title`, `Author`, `Category`, `SubCategory`, `ISBN`, `Description`, `FullDescription`, 
                            `CoverFront`, `CoverBack`, `Price` FROM `book`";
                    $result= $conn->query($query);
                    $Books=array();
                    foreach($result as $r)
                    {
                        $book = new book();
                        $book->setBID($r[0]);
                        $book->setTitle($r[1]);
                        $book->setAuthor($r[2]);
                        $book->setCategory($r[3]);
                        $book->setSubCategory($r[4]);
                        $book->setISBN($r[5]);
                        $book->setDescription($r[6]);
                        $book->setFullDiscription($r[7]);
                        $book->setCoverFront($r[8]);
                        $book->setCoverBack($r[9]);
                        $book->setPrice($r[10]);
                        
                        array_push($Books,$book);
                    }
                    return $Books;

                } catch (Exception $e) {
                    throw $e;
                }
            }

            public function GetBook()

            {
                try {
                    
                    $conn= Config::GetConnection();
                    $query= "SELECT `BID`, `Title`, `Author`, `Category`, `SubCategory`, `ISBN`, `Description`, `FullDescription`, 
                            `CoverFront`, `CoverBack`, `Price` FROM `book`";
                    $stmt= $conn->query($query);
                    $stmt->bindParam(1,$this->BID,PDO::PARAM_STR); 
                    $stmt->execute();
                    $result =$stmt->fetchAll();
                    $book = new Book();
                    foreach($result as $r)
                    {
                        $book = new book();
                        $book->setBID($r[0]);
                        $book->setTitle($r[1]);
                        $book->setAuthor($r[2]);
                        $book->setCategory($r[3]);
                        $book->setSubCategory($r[4]);
                        $book->setISBN($r[5]);
                        $book->setDescription($r[6]);
                        $book->setFullDiscription($r[7]);
                        $book->setCoverFront($r[8]);
                        $book->setCoverBack($r[9]);
                        $book->setPrice($r[10]);
                        
                
                    }
                    return $book;

                } catch (Exception $e) {
                    throw $e;
                }
            }


}


?>