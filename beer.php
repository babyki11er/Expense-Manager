<html>
  <head>
    <link rel="stylesheet" href="./css/beer.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
  </head>
<body>
<?php require_once "./nav-bar.php" ?>
<!-- ADD NEW CATEGORY FORM -->
<div class=" w-50">
    <form action="./api/add-api.php" method="post" class=" p-4">
        <div class="mb-2">
            <label for="" class=" form-label">
                New Category
            </label>
        </div>
        <div class=" input-group" id="dd">
            <input name="value" type="text" id="search-bar" placeholder="Enter new category" class=" form-control" autofocus autocomplete="off"/>
            <button class="btn btn-primary col-4">Add</button>
        </div>
    </form>
</div>
<script src="./js/functions.js"></script>
<script src="./js/dd.js"></script>
<?php require_once "./footer.php"; ?>