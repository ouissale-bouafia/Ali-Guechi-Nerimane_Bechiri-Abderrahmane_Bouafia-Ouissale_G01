
(: ========================= :)
(: Q1 - Liste des membres :)
(: ========================= :)

(: Loop through all members in the XML document :)
for $m in doc("club.xml")//membre

(: Find the category corresponding to the current member :)
let $cat :=
doc("club.xml")//categorie[@id = $m/@categorieRef]

(: Return a new XML structure containing member information :)
return

<membre id="{$m/@id}">

    (: Combine first name and last name into one field :)
    <nomComplet>
        {concat($m/prenom, " ", $m/nom)}
    </nomComplet>

    (: Display the member email :)
    <email>
        {$m/email}
    </email>

    (: Display the category label of the member :)
    <categorie>
        {$cat/@libelle}
    </categorie>

</membre>


(: ========================= :)
(: Q2 - Liste des concours :)
(: ========================= :)

(: Loop through all competitions in the XML document :)
for $c in doc("club.xml")//concours/concours

(: Find the category corresponding to the current competition :)
let $cat :=
doc("club.xml")//categorie[@id = $c/@categorieRef]

(: Sort competitions by date :)
order by $c/@date

(: Return a new XML structure containing competition information :)
return

<concours>

    (: Display the competition title :)
    <titre>
        {$c/titre}
    </titre>

    (: Display the competition date :)
    <date>
        {$c/@date}
    </date>

    (: Display the competition coefficient :)
    <coefficient>
        {$c/@coefficient}
    </coefficient>

    (: Display the category label of the competition :)
    <categorie>
        {$cat/@libelle}
    </categorie>

</concours>


(: ========================= :)
(: Q3 - Calcul des scores :)
(: ========================= :)

(: Loop through all competitions in the XML document :)
for $c in doc("club.xml")//concours/concours

(: Return a new XML structure for each competition :)
return

<concours titre="{$c/titre}">

{

    (: Loop through all participants of the current competition :)
    for $p in $c/participants/participant

    (: Find the member corresponding to the participant :)
    let $m :=
    doc("club.xml")//membre[@id = $p/@membreRef]

    (: Calculate the participant score :)
    let $score :=
    (xs:integer($p/complexite) + xs:integer($p/tempsExecution))
    * xs:decimal($c/@coefficient)

    (: Return participant information with calculated score :)
    return

    <participant>

        (: Display participant last name :)
        <nom>
            {$m/nom}
        </nom>

        (: Display participant first name :)
        <prenom>
            {$m/prenom}
        </prenom>

        (: Display complexity value :)
        <complexite>
            {$p/complexite}
        </complexite>

        (: Display execution time :)
        <tempsExecution>
            {$p/tempsExecution}
        </tempsExecution>

        (: Display rounded score value :)
        <score>
            {round($score * 100) div 100}
        </score>

    </participant>
}

</concours>

(: ========================= :)
(: Q4 - Vainqueur :)
(: ========================= :)

(: Loop through all competitions in the XML document :)
for $c in doc("club.xml")//concours/concours

(: Calculate all participant scores for the current competition :)
let $scores :=

    for $p in $c/participants/participant

    return
    (
        (xs:integer($p/complexite) + xs:integer($p/tempsExecution))
        * xs:decimal($c/@coefficient)
    )

(: Find the highest score in the competition :)
let $maxScore := max($scores)

(: Return a new XML structure containing the winner information :)
return

<concours titre="{$c/titre}">

{

    (: Loop through all participants again :)
    for $p in $c/participants/participant

    (: Calculate the score of the current participant :)
    let $score :=
    (xs:integer($p/complexite) + xs:integer($p/tempsExecution))
    * xs:decimal($c/@coefficient)

    (: Keep only participants having the maximum score :)
    where $score = $maxScore

    (: Find the member corresponding to the winner :)
    let $m :=
    doc("club.xml")//membre[@id = $p/@membreRef]

    (: Return winner information :)
    return

    <vainqueur>

        (: Display winner last name :)
        <nom>
            {$m/nom}
        </nom>

        (: Display winner first name :)
        <prenom>
            {$m/prenom}
        </prenom>

        (: Display winner score :)
        <score>
            {$score}
        </score>

    </vainqueur>
}

</concours>


(: ========================= :)
(: Q5 - Membres par categorie :)
(: ========================= :)

(: Declare a variable containing the selected category name :)
declare variable $categorie := "Intelligence Artificielle";

(: Loop through all members in the XML document :)
for $m in doc("club.xml")//membre

(: Find the category corresponding to each member :)
let $cat :=
doc("club.xml")//categorie[@id = $m/@categorieRef]

(: Filter members belonging to the selected category :)
where $cat/@libelle = $categorie

(: Sort results alphabetically by last name and first name :)
order by $m/nom, $m/prenom

(: Return a simplified XML structure for each member :)
return

<membre>

    (: Display member last name :)
    <nom>
        {$m/nom}
    </nom>

    (: Display member first name :)
    <prenom>
        {$m/prenom}
    </prenom>

</membre>
