<?php
function asideLayout($database)
{
    ?>

    <head>
        <link rel="stylesheet" href="src/css/aside.css">
    </head>
    <?php foreach ($database->getAllCategories() as $category) { ?>
        <li class="list-group"><a href='/productCatagoryList?id=<?php echo $category->id ?>'
                class="list-group-item list-group-item-action list-group-item-success">
                <?php echo $category->title ?>
            </a></li>
    <?php } ?>
<?php
}
?>