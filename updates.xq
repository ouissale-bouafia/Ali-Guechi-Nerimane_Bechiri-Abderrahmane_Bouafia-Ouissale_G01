
(: ========================= :)
(: 1 - INSERT MEMBER :)
(: ========================= :)

(: Enable the writeback option to save changes directly to the original XML file :)
declare option db:writeback "true";

(: Insert a new member node with its attributes and child elements :)
insert node <membre id="M014" categorieRef="C2">
    <nom>Zerrouk</nom>
    <prenom>Lyna</prenom>
    <email>l.zerrouk@club.dz</email>
</membre>
(: Specify the target destination: inside the <membres> element of the given XML file :)
into doc("C:/Users/DynaBook/Downloads/BaseX123/basex/club.xml")//membres


(: ========================= :)
(: 2 - UPDATE COEFFICIENT :)
(: ========================= :)

(: Enable the writeback option to permanently save updates to the original XML file :)
declare option db:writeback "true";

(: Target the specific attribute value and replace it with the new value :)
replace value of node doc("C:/Users/DynaBook/Downloads/BaseX123/basex/club.xml")//concours[@id="CO2"]/@coefficient
with "2.0"


(: ========================= :)
(: 3 - DELETE PARTICIPANT :)
(: ========================= :)

(: Delete a specific node from the XML document :)

(: Select the participant with membreRef = "M003" inside competition CO1 :)
delete node
doc("club.xml")//concours[@id="CO1"]
               //participant[@membreRef="M003"]