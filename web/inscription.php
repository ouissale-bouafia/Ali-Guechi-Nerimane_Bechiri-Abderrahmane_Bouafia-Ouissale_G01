<?php include("header.php"); ?>

<h2 class="page-title">Competition Registration</h2>

<form method="post" class="form-box">

    <label>Select Member</label>
    <select name="member">
        <option value="">-- Choose a Member --</option>
        <?php foreach($xml->membres->membre as $m): ?>
            <option value="<?= $m['id'] ?>">
                <?= $m->prenom . " " . $m->nom ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Select Competition</label>
    <select name="competition">
        <option value="">-- Choose a Competition --</option>
        <?php foreach($xml->concours->concours as $c): ?>
            <option value="<?= $c['id'] ?>">
                <?= $c->titre ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Register</button>

</form>

<?php



function getMemberCategory($xml, $memberId) {
    foreach ($xml->membres->membre as $m) {
        if ((string)$m['id'] == $memberId) {
            return (string)$m['categorieRef'];
        }
    }
    return null;
}

function getCompetitionCategory($xml, $competitionId) {
    foreach ($xml->concours->concours as $c) {
        if ((string)$c['id'] == $competitionId) {
            return (string)$c['categorieRef'];
        }
    }
    return null;
}


function isAlreadyRegistered($xml, $memberId) {

    foreach ($xml->concours->concours as $c) {
        foreach ($c->participants->participant as $p) {
            if ((string)$p['membreRef'] == $memberId) {
                return true;
            }
        }
    }

    return false;
}



if ($_POST) {

    $member = $_POST['member'];
    $competition = $_POST['competition'];

  
    $memberCat = getMemberCategory($xml, $member);
    $compCat   = getCompetitionCategory($xml, $competition);

    if ($memberCat !== $compCat) {
        echo "<div class='error'>❌ You cannot register: category mismatch.</div>";
        include("footer.php");
        exit;
    }

    
    if (isAlreadyRegistered($xml, $member)) {
        echo "<div class='error'>❌ Member already registered in another competition.</div>";
        include("footer.php");
        exit;
    }

    
    foreach ($xml->concours->concours as $c) {

        if ((string)$c['id'] == $competition) {

            $participant = $c->participants->addChild("participant");
            $participant->addAttribute("membreRef", $member);

            $participant->addChild("complexite", rand(50, 100));
            $participant->addChild("tempsExecution", rand(80, 200));

            break;
        }
    }

   
    $xml->asXML("club.xml");

    echo "<div class='success'>✔ Registration successful.</div>";
}

?>

<?php include("footer.php"); ?>