<?php include("header.php"); ?>

<h2 class="page-title">
    Competition Results
</h2>

<form method="get" class="form-box">

    <label>Select Competition</label>

    <select name="competition" required>

      
        <option value="" disabled selected>
            Select Competition
        </option>

        <?php
        foreach($xml->concours->concours as $c){
            echo '<option value="'.$c['id'].'">'
                .$c->titre.
            '</option>';
        }
        ?>

    </select>

    <button type="submit">
        Show Results
    </button>

</form>

<?php

if(isset($_GET['competition']) && $_GET['competition'] !== ""){

    $competitionId = $_GET['competition'];

    foreach($xml->concours->concours as $c){

        if((string)$c['id'] == $competitionId){

            echo "<div class='card-result'>";

            echo "<h3>".$c->titre."</h3>";

            $results = [];
            $maxScore = 0;

            foreach($c->participants->participant as $p){

                $complexite = (int)$p->complexite;
                $temps = (int)$p->tempsExecution;
                $coef = (float)$c['coefficient'];

                $score = ($complexite + $temps) * $coef;

                $memberId = (string)$p['membreRef'];
                $memberName = "";

                foreach($xml->membres->membre as $m){

                    if((string)$m['id'] == $memberId){
                        $memberName = $m->prenom." ".$m->nom;
                        break;
                    }
                }

                $results[] = [
                    "name" => $memberName,
                    "score" => $score
                ];

                if($score > $maxScore){
                    $maxScore = $score;
                }
            }

            usort($results, function($a, $b){
                return $b['score'] <=> $a['score'];
            });

            echo "
            <table>
                <tr>
                    <th>Rank</th>
                    <th>Participant</th>
                    <th>Score</th>
                </tr>
            ";

            $rank = 1;

            foreach($results as $r){

                $class = "";

                if($r['score'] == $maxScore){
                    $class = "winner";
                }

                echo "
                <tr class='".$class."'>
                    <td>".$rank."</td>
                    <td>".$r['name']."</td>
                    <td>".number_format($r['score'],2)."</td>
                </tr>
                ";

                $rank++;
            }

            echo "</table>";
            echo "</div>";
        }
    }

}else{

    echo "<div class='card-result'>
            <h3>Competition Results</h3>
            <p>Please select a competition to view results.</p>
          </div>";
}

?>

<?php include("footer.php"); ?>