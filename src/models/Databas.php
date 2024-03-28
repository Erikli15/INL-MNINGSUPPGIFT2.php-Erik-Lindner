<?php
require_once ("src/models/Product.php");
require_once ("src/models/Catagory.php");
class Databas
{
    private $host = "localhost";
    private $db = "productdatabas";
    private $user = "root";
    private $pass = "root";
    private $charset = "utf8mb4";

    private $pdo;

    function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->db";
        $this->pdo = new PDO($dsn, $this->user, $this->pass);
        $this->ifTabletNotExist();
        $this->ifProductsNotExist();
    }
    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Catagory');

    }

    function searchProducts($sortCol, $sortOrder, $q, $categoryId)
    {
        if ($sortCol == null) {
            $sortCol = "id";
        }
        if ($sortOrder == null) {
            $sortOrder = "asc";
        }
        $sql = "SELECT * FROM products";
        $categoryArray = [];
        $addedWhere = false;
        if ($q != null && strlen($q) > 0) {
            if (!$addedWhere) {
                $sql .= " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql .= " AND ";
            }
            $sql = $sql . " (productName like :q";
            $sql = $sql . " ( or price like :q";
            $categoryArray["q"] = "%" - $q . "%";
        }
        if ($categoryId != null && strlen($categoryId) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " CategoryId=:CategoryId)";
            $categoryArray["CategoryId"] = $categoryId;
        }


        $sql .= " ORDER BY $sortCol $sortOrder";
        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, "Product");
        $prep->execute($categoryArray);

        return $prep->fetchAll();
    }
    function getProduct($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }
    function getProductByTitle($productName)
    {
        $prep = $this->pdo->prepare('SELECT * FROM products where productName=:productName');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Product');
        $prep->execute(['productName' => $productName]);
        return $prep->fetch();
    }

    function getCategoryByTitle($title): Catagory|false
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Catagory');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }
    function ifProductsNotExist()
    {
        static $products = false;
        if ($products)
            return;

        $this->createIfNotExisting('Chai', 18, 'Beverages');
        $this->createIfNotExisting('Chang', 19, 'Beverages');
        $this->createIfNotExisting('Aniseed Syrup', 10, 'Condiments');
        $this->createIfNotExisting('Chef Antons Cajun Seasoning', 22, 'Condiments');
        $this->createIfNotExisting('Chef Antons Gumbo Mix', 21, 'Condiments');
        $this->createIfNotExisting('Grandmas Boysenberry Spread', 25, 'Condiments');
        $this->createIfNotExisting('Uncle Bobs Organic Dried Pears', 30, 'Produce');
        $this->createIfNotExisting('Northwoods Cranberry Sauce', 40, 'Condiments');
        $this->createIfNotExisting('Mishi Kobe Niku', 97, 'Meat/Poultry');
        $this->createIfNotExisting('Ikura', 31, 'Seafood');
        $this->createIfNotExisting('Queso Cabrales', 21, 'Dairy Products');
        $this->createIfNotExisting('Queso Manchego La Pastora', 38, 'Dairy Products');
        $this->createIfNotExisting('Konbu', 6, 'Seafood');
        $this->createIfNotExisting('Tofu', 22, 'Produce');
        $this->createIfNotExisting('Genen Shouyu', 18, 'Condiments');
        $this->createIfNotExisting('Pavlova', 12, 'Confections');
        $this->createIfNotExisting('Alice Mutton', 39, 'Meat/Poultry');
        $this->createIfNotExisting('Carnarvon Tigers', 231, 'Seafood');
        $this->createIfNotExisting('Teatime Chocolate Biscuits', 213, 'Confections');
        $this->createIfNotExisting('Sir Rodneys Marmalade', 81, 'Confections');
        $this->createIfNotExisting('Sir Rodneys Scones', 10, 'Confections');
        $this->createIfNotExisting('Gustafs Knäckebröd', 21, 'Grains/Cereals');
        $this->createIfNotExisting('Tunnbröd', 9, 'Grains/Cereals');
        $this->createIfNotExisting('Guaraná Fantástica', 231, 'Beverages');
        $this->createIfNotExisting('NuNuCa Nuß-Nougat-Creme', 14, 'Confections');
        $this->createIfNotExisting('Gumbär Gummibärchen', 312, 'Confections');
        $this->createIfNotExisting('Schoggi Schokolade', 213, 'Confections');
        $this->createIfNotExisting('Rössle Sauerkraut', 132, 'Produce');
        $this->createIfNotExisting('Thüringer Rostbratwurst', 231, 'Meat/Poultry');
        $this->createIfNotExisting('Nord-Ost Matjeshering', 321, 'Seafood');
        $this->createIfNotExisting('Gorgonzola Telino', 321, 'Dairy Products');
        $this->createIfNotExisting('Mascarpone Fabioli', 32, 'Dairy Products');
        $this->createIfNotExisting('Geitost', 12, 'Dairy Products');
        $this->createIfNotExisting('Sasquatch Ale', 14, 'Beverages');
        $this->createIfNotExisting('Steeleye Stout', 18, 'Beverages');
        $this->createIfNotExisting('Inlagd Sill', 19, 'Seafood');
        $this->createIfNotExisting('Gravad lax', 26, 'Seafood');
        $this->createIfNotExisting('Côte de Blaye', 1, 'Beverages');
        $this->createIfNotExisting('Chartreuse verte', 18, 'Beverages');
        $this->createIfNotExisting('Boston Crab Meat', 2, 'Seafood');
        $this->createIfNotExisting('Jacks New England Clam Chowder', 2, 'Seafood');
        $this->createIfNotExisting('Singaporean Hokkien Fried Mee', 14, 'Grains/Cereals');
        $this->createIfNotExisting('Ipoh Coffee', 46, 'Beverages');
        $this->createIfNotExisting('Gula Malacca', 2, 'Condiments');
        $this->createIfNotExisting('Rogede sild', 3, 'Seafood');
        $this->createIfNotExisting('Spegesild', 12, 'Seafood');
        $this->createIfNotExisting('Zaanse koeken', 4, 'Confections');
        $this->createIfNotExisting('Chocolade', 6, 'Confections');
        $this->createIfNotExisting('Maxilaku', 5, 'Confections');
        $this->createIfNotExisting('Valkoinen suklaa', 1, 'Confections');
        $this->createIfNotExisting('Manjimup Dried Apples', 53, 'Produce');
        $this->createIfNotExisting('Filo Mix', 7, 'Grains/Cereals');
        $this->createIfNotExisting('Perth Pasties', 4, 'Meat/Poultry');
        $this->createIfNotExisting('Tourtière', 7, 'Meat/Poultry');
        $this->createIfNotExisting('Pâté chinois', 24, 'Meat/Poultry');
        $this->createIfNotExisting('Gnocchi di nonna Alice', 38, 'Grains/Cereals');
        $this->createIfNotExisting('Ravioli Angelo', 7, 'Grains/Cereals');
        $this->createIfNotExisting('Escargots de Bourgogne', 7, 'Seafood');
        $this->createIfNotExisting('Raclette Courdavault', 55, 'Dairy Products');
        $this->createIfNotExisting('Camembert Pierrot', 34, 'Dairy Products');
        $this->createIfNotExisting('Sirop dérable', 7, 'Condiments');
        $this->createIfNotExisting('Tarte au sucre', 7, 'Confections');
        $this->createIfNotExisting('Vegie-spread', 7, 'Condiments');
        $this->createIfNotExisting('Wimmers gute Semmelknödel', 7, 'Grains/Cereals');
        $this->createIfNotExisting('Louisiana Fiery Hot Pepper Sauce', 7, 'Condiments');
        $this->createIfNotExisting('Louisiana Hot Spiced Okra', 17, 'Condiments');
        $this->createIfNotExisting('Laughing Lumberjack Lager', 14, 'Beverages');
        $this->createIfNotExisting('Scottish Longbreads', 8, 'Confections');
        $this->createIfNotExisting('Gudbrandsdalsost', 8, 'Dairy Products');
        $this->createIfNotExisting('Outback Lager', 15, 'Beverages');
        $this->createIfNotExisting('Flotemysost', 8, 'Dairy Products');
        $this->createIfNotExisting('Mozzarella di Giovanni', 8, 'Dairy Products');
        $this->createIfNotExisting('Röd Kaviar', 15, 'Seafood');
        $this->createIfNotExisting('Longlife Tofu', 10, 'Produce');
        $this->createIfNotExisting('Rhönbräu Klosterbier', 9, 'Beverages');
        $this->createIfNotExisting('Lakkalikööri', 9, 'Beverages');
        $this->createIfNotExisting('Original Frankfurter grüne Soße', 13, 'Condiments');
        $this->createIfNotExisting('Tidningen Buster', 13, 'Tidningar');
        $this->createIfNotExisting("dator", 10000, "pc");
        $this->createIfNotExisting("telefon", 5000, "telefon");
        $this->createIfNotExisting("Penna", 20, "tillbehör");
        $this->createIfNotExisting("USB", 50, "usb");
        $this->createIfNotExisting("Appleklocka", 200, "klocka");
        $this->createIfNotExisting("hörlur", 300, "hörlur");
        $this->createIfNotExisting("hdmi-kabel", 100, "sladd");
        $this->createIfNotExisting("nätverks-kabel", 80, "nätver");
        $this->createIfNotExisting("router", 350, "router");
        $this->createIfNotExisting("tv", 15000, "tv");
        $products = true;

    }

    function createIfNotExisting($productName, $price, $categoryName)
    {
        $existing = $this->getProductByTitle($productName);
        if ($existing) {
            return;
        }
        ;
        return $this->addProduct($productName, $price, $categoryName);
    }

    function addCategory($title)
    {
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(["title" => $title]);
        return $this->pdo->lastInsertId();
    }

    function addProduct($productName, $price, $categoryName)
    {
        $category = $this->getCategoryByTitle($categoryName);
        if ($category == false) {
            $this->addCategory($categoryName);
            $category = $this->getCategoryByTitle($categoryName);
        }
        $prep = $this->pdo->prepare('INSERT INTO products (productName, price, categoryId) VALUES(:productName, :price, :categoryId )');
        $prep->execute(["productName" => $productName, "price" => $price, "categoryId" => $category->id]);
        return $this->pdo->lastInsertId();
    }
    function ifTabletNotExist()
    {

        static $initialized = false;
        if ($initialized)
            return;


        $sql = "CREATE TABLE IF NOT EXISTS `category` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `title` varchar(200) NOT NULL,
            PRIMARY KEY (`id`)
            ) ";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT NOT NULL,
            `productName` varchar(200) NOT NULL,
            `price` INT,
            `categoryId` INT NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`)
            REFERENCES category(id)
            ) ";

        $this->pdo->exec($sql);

        $initialized = true;
    }

}
