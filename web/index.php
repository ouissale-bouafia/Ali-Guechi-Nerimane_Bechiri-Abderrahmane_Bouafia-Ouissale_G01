<?php include("header.php"); ?>

<section class="hero">

    <h2>
        Welcome to Info_Tech Club
    </h2>

    <p>
        XML — XSD — XQuery Dynamic Web Application
    </p>

</section>

<section class="stats">

    <div class="card">
        <h3>
            <?php echo count($xml->categories->categorie); ?>
        </h3>

        <p>Categories</p>
    </div>

    <div class="card">
        <h3>
            <?php echo count($xml->membres->membre); ?>
        </h3>

        <p>Members</p>
    </div>

    <div class="card">
        <h3>
            <?php echo count($xml->concours->concours); ?>
        </h3>

        <p>Competitions</p>
    </div>

</section>

<?php include("footer.php"); ?>