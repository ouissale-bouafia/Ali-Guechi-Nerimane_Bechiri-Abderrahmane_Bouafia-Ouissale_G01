<?php include("header.php"); ?>

<h2 class="page-title">
    Competitions List
</h2>

<table>

    <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Category</th>
        <th>Coefficient</th>
    </tr>

<?php

foreach($xml->concours->concours as $c){

    $catId = (string)$c['categorieRef'];

    $catLabel = "";

    foreach($xml->categories->categorie as $cat){

        if((string)$cat['id'] == $catId){

            $catLabel = $cat['libelle'];
            break;
        }
    }

    echo "<tr>";

    echo "<td>".$c->titre."</td>";

    echo "<td>".$c['date']."</td>";

    echo "<td>".$catLabel."</td>";

    echo "<td>".$c['coefficient']."</td>";

    echo "</tr>";
}

?>

</table>

<?php include("footer.php"); ?>