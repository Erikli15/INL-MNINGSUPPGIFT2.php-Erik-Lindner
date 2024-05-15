<?php
require_once ("src/models/Product.php");
require_once ("src/models/Catagory.php");
require_once ("src/models/userDatabas.php");
require_once ("src/migrations/migrationBase.php");
require_once ("src/Function/ifProductsNotExist.php");
$database = new Databas();
$products = ifProductsNotExist();

foreach ($products as $product) {
    if (isset($product["description"], $product["imgUrl"])) {
        $database->createIfNotExisting($product["productName"], $product["price"], $product["categoryName"], $product["description"], $product["imgUrl"]);
    } else {
        echo "Error";
    }
}
class Databas
{

    public $pdo;
    private $userDatabas;

    function getUserDatabas()
    {
        return $this->userDatabas;
    }
    function __construct()
    {
        $host = $_ENV["host"];
        $db = $_ENV["db"];
        $user = $_ENV['user'];
        $pass = $_ENV['pass'];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->userDatabas = new userDatabas($this->pdo);
        $this->ifTabletNotExist();
    }
    function getAllCategories()
    {
        return $this->pdo->query('SELECT * FROM category')->fetchAll(PDO::FETCH_CLASS, 'Catagory');

    }

    function getPopularProducts()
    {
        return $this->pdo->query('SELECT * FROM products order by popularity desc limit 0,10')->fetchAll(PDO::FETCH_CLASS, 'Product');

    }
    function searchProducts($sortCol, $sortOrder, $q, $categoryId, $pageNo = 1, $pageSize = 20)
    {
        if ($sortCol == null) {
            $sortCol = "id";
        }
        if ($sortOrder == null) {
            $sortOrder = "asc";
        }
        $sql = "SELECT * FROM products";
        $paramsArray = [];
        $addedWhere = false;
        if ($q != null && strlen($q) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " (productName like :q";
            $sql = $sql . " or price like :q)";
            $paramsArray["q"] = "%" . $q . "%";
        }
        if ($categoryId != null && strlen($categoryId) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " (categoryId = :categoryId)";
            $paramsArray["categoryId"] = $categoryId;
        }


        $sql .= " ORDER BY $sortCol $sortOrder ";

        $sqlCount = str_replace("SELECT * FROM ", "SELECT CEIL (COUNT(*)/$pageSize) FROM ", $sql);

        // $pageNo = 1, $pageSize = 20
        $offset = ($pageNo - 1) * $pageSize;
        $sql .= " limit $offset, $pageSize";


        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, "Product");
        $prep->execute($paramsArray);

        $data = $prep->fetchAll();

        $prep2 = $this->pdo->prepare($sqlCount);
        $prep2->execute($paramsArray);

        $num_pages = $prep2->fetchColumn();

        $arr = ["data" => $data, "num_pages" => $num_pages];
        return $arr;
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

    function getCategoryByTitle($title)
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where title=:title');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Catagory');
        $prep->execute(['title' => $title]);
        return $prep->fetch();
    }


    function getCatagory($id)
    {
        $prep = $this->pdo->prepare('SELECT * FROM category where id=:id');
        $prep->setFetchMode(PDO::FETCH_CLASS, 'Catagory');
        $prep->execute(['id' => $id]);
        return $prep->fetch();
    }

    function createIfNotExisting($productName, $price, $categoryName, $description, $imgUrl)
    {
        $existing = $this->getProductByTitle($productName);
        if ($existing) {
            return;
        }
        ;

        return $this->addProduct($productName, $price, $categoryName, $description, $imgUrl);
    }

    function addCategory($title)
    {
        $prep = $this->pdo->prepare('INSERT INTO category (title) VALUES(:title )');
        $prep->execute(["title" => $title]);
        return $this->pdo->lastInsertId();
    }

    function addProduct($productName, $price, $categoryName, $description, $imgUrl)
    {
        $category = $this->getCategoryByTitle($categoryName);
        if ($category == false) {
            $this->addCategory($categoryName);
            $category = $this->getCategoryByTitle($categoryName);
        }
        $prep = $this->pdo->prepare('INSERT INTO products (productName, price, categoryId, description, imgUrl) VALUES(:productName, :price, :categoryId, :description, :imgUrl)');
        $prep->execute(["productName" => $productName, "price" => $price, "categoryId" => $category->id, "description" => $description, "imgUrl" => $imgUrl]);
        return $this->pdo->lastInsertId();
    }

    function updateProuct($id, $productName, $price, $categoryId, $descrption, $imgUrl)
    {
        $prep = $this->pdo->prepare("UPDATE Product SET
        productName=:productName, price=:price ,categoryId=:categoryId, descrption=:descrption, imgUrl=:imgUrl
        WHERE id= :id");
        $prep->execute(["productName" => $productName, "price" => $price, "categoryId" => $categoryId, "descrption" => $descrption, "imgUrl" => $imgUrl, "id" => $id]);
    }

    function addProuct($productName, $price, $categoryId, $description, $imgUrl)
    {
        $prep = $this->pdo->prepare("UPDATE INTO Product
        (productName, price, categoryId, descrption imgUrl) 
        (:productName, :price, :categoryId, :descrption, :imgUrl);");
        $prep->execute([
            "productName" => $productName,
            "price" => $price,
            "categoryId" => $categoryId,
            "description" => $description,
            "imgUrl" => $imgUrl
        ]);
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
            `description` varchar(1000),
            `imgUrl` VARCHAR(500),
            PRIMARY KEY (`id`),
            FOREIGN KEY (`categoryId`)
            REFERENCES category(id)
            ) ";

        $this->pdo->exec($sql);

        $this->userDatabas->setUpUser();
        $this->userDatabas->seedUser();

        new Migrator($this->pdo);

        $initialized = true;
    }


}


