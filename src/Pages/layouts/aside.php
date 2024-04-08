<?php
function asideLayout($database)
{
    ?>

    <head>
        <link rel="stylesheet" href="src/css/aside.css">
    </head>
    <?php foreach ($database->getAllCategories() as $category) { ?>
        <li><a href='/productCatagoryList?id=<?php echo $category->id ?>'>
                <?php echo $category->title ?>
            </a></li>
    <?php } ?>
<?php
}
?>