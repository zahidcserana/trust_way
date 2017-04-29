<?php
    class ProductInfo
    {
        private $db=null;
        function __construct()
        {
            $this->db = Database::GetDatabaseConnection();
        }
        function InsertNewProduct($productId,$category,$price,$imageUpload)
        {
            $query = "INSERT INTO products(product_id,category,price,location)
            VALUES (?, ?, ?,?)";
            $parameters = array($productId,$category,$price,$imageUpload);
            $types = array("s","s","s","s");
            return $this->db->Insert($query, $parameters, $types);
        }
        function RemoveProduct($pId,$cartId)
        {
            $query = "DELETE  FROM products WHERE product_id =$pId  AND cart_id=$cartId";
            $parameter = array($pId,$cartId);
            $types = array("s","s");
            return $this->db->Delete($query);
        }
       
        function redirect($url)
        {
            header("Location: $url");
        }
       

        function GetProdPrice($productId)
        {
            $query = "SELECT price FROM products WHERE product_id = ?";
            $parameter = array($productId);
            $type = array("s");
            return $this->db->GetRowList($query, $parameter, $type);
        }
        
        function GetProductList()
        {
            $query = "SELECT * FROM products ";
            return $this->db->GetManyRow($query);
        }
        
        function GetProductImg($productId)
        {
            $query = "SELECT * FROM products WHERE product_id = ?";
            $parameter = array($productId);
            $type = array("s");
            return $this->db->GetRow($query, $parameter, $type);
        }

        function GetAllProduct()
        {
            $query = "SELECT * FROM products ";
            return $this->db->GetManyRow($query);
        }
        
        function CategoryUpdate($category,$productId)
        {
            $query = "UPDATE products SET category=? WHERE product_id=?";
            $parameters = array($category,$productId);
            $types = array("s","s");
            return $this->db->Update($query, $parameters, $types);
        }
        function PriceUpdate($price,$productId)
        {
            $query = "UPDATE products SET price=? WHERE product_id=?";
            $parameters = array($price,$productId);
            $types = array("s","s");
            return $this->db->Update($query, $parameters, $types);
        }      
        
        function ImageChange($imgUrl,$productId)
        {
            $query = "UPDATE products SET location=? WHERE product_id=?";
            $parameters = array($imgUrl,$productId);
            $types = array("s","s");
            return $this->db->Update($query, $parameters, $types);
        } 
    }
?>




