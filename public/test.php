<?php
require_once "../globals.php";
require_once "../index.php";
?>
<?php require_once TEMPLATE_DIR . '/header.php' ?>
<h1>My Lists</h1>
<div class=" d-flex justify-content-between mb-3">
    <a href="/income/add" class=" btn btn-dark">Add New</a>
    <form action="" method="get">
        <div class=" input-group">
            <!-- yellow -->
            <input type="text" name="q" value="" class=" form-control">
            <?php if (!empty($query)) : ?>
                <a href="" class=" btn btn-danger">
                    Del
                </a>
            <?php endif; ?>
            <button class=" btn btn-primary">Search</button>
        </div>
    </form>
</div>


<div class=" d-flex justify-content-between mb-3">
    <a href="" class=" btn btn-outline-primary">Create New</a>
    <form action="" method="get">
        <div class=" input-group">
            <input type="text" name="q" value="" class=" form-control">
            
                <a href="" class=" btn btn-danger">
                    Del
                </a>
            
            <button class=" btn btn-primary">Search</button>
        </div>
    </form>
</div>

<table class=" table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Money</th>
            <th>Control</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>

        
            <tr>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    <a href="" class=" btn btn-sm btn-outline-info">
                        Edit
                    </a>
                    <form class=" d-inline-block" action="" method="post">
                        <input type="hidden" name="id" value="">
                        <input type="hidden" name="_method" value="delete">
                        <button class=" btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
                <td>
                    
                </td>
            </tr>
    </tbody>
</table>
<table class=" table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Label</th>
            <th>Amount</th>
            <th>Note</th>
            <th>Control</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($incomes as $income) : ?>
            <tr>
                <td>
                    <?= $income['date']; ?>
                </td>
                <td>
                    <?= $income['label']; ?>
                </td>
                <td>
                    <?= displayMoney($income['amount']); ?>
                </td>
                <td>
                    <?= $income['note']; ?>
                </td>
                <td>
                    <a href="#" class=" btn btn-sm btn-outline-info">
                        Edit
                    </a>
                    <form action="/api/del" class=" d-inline-block" method="post">
                        <input type="hidden" name="id" value="<?= $income['id'] ?>">
                        <input type="hidden" name="selected" value="income">
                        <button class=" btn btn-sm btn-outline-danger" name="del">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

    </tbody>
</table>
</div>
<div class=" d-flex justify-content-between mb-3">
    <a href="" class=" btn btn-outline-primary">Create New</a>
    <form action="" method="get">
        <div class=" input-group">
            <input type="text" name="q" value="" class=" form-control">
            <?php if (isset($_GET['q'])) : ?>
                <a href="" class=" btn btn-danger">
                    Del
                </a>
            <?php endif; ?>
            <button class=" btn btn-primary">Search</button>
        </div>
    </form>
</div>
<?php require_once TEMPLATE_DIR . '/footer.php'; ?>
<!-- <script>alert("hhz")</script> -->