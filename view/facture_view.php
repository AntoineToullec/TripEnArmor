<!-- 
    POUR UTILISER LA VUE, définir les variables suivantes avant de l'appeler
    $id_offre
-->

<?php
// CHARGER LES INFORAMTIONS DE LA FACTURE
require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php_files/connect_to_bdd.php';

// L'offre et le pro concerné
$stmt = $dbh->prepare("SELECT * FROM sae_db._offre WHERE id_offre = :id_offre");
$stmt->bindParam(':id_offre', $id_offre);
$stmt->execute();
$offre = $stmt->fetch();

$id_pro = $offre['id_pro'];
$stmt = $dbh->prepare("SELECT * FROM sae_db._pro_prive WHERE id_compte = :id_pro");
$stmt->bindParam(':id_pro', $id_pro);
$stmt->execute();
$pro_details = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtAdresse = $dbh->prepare("SELECT * FROM sae_db._adresse WHERE id_adresse = :id_adresse");
$stmtAdresse->bindParam(':id_adresse', $pro_details['id_adresse'], PDO::PARAM_INT);
$stmtAdresse->execute();
$adresse_details = $stmtAdresse->fetch(PDO::FETCH_ASSOC);

// Les paiements liés à l'offre
$stmt = $dbh->prepare("SELECT * FROM sae_db.vue_periodes_en_ligne_du_mois WHERE id_offre = :id_offre");
$stmt->bindParam(':id_offre', $id_offre);
$stmt->execute();
$periodes_en_ligne = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $dbh->prepare("SELECT * FROM sae_db.vue_souscription_offre_option_details_du_mois WHERE id_offre = :id_offre");
$stmt->bindParam(':id_offre', $id_offre);
$stmt->execute();
$options_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Dates et numéro de facture
$date_emission = date('d/m/Y');
$date_echeance = date('01/m/Y', strtotime('first day of next month'));
?>

<!-- FACTURE AVEC TOUS LES DETAILS -->
<div id="facture-details" class="border border-black p-5 flex flex-col mx-auto my-5 gap-5 max-w-4xl">
    <?php
    $TVA = 20;
    $numero = "2024-FAC-0001";
    ?>

    <!-- En-tête -->
    <div class="flex flex-col justify-between">
        <!-- LA PACT -->
        <div class="flex justify-between w-full">
            <div>
                <h1 class="text-xl font-bold">PACT</h1>
                <p>21 rue Case Nègres<br>97232, Fort-de-France<br>FR</p>
            </div>
        </div>

        <!-- Informations du pro -->
        <div class="flex justify-end">
            <div>
                <h1 class="text-xl font-bold"><?php echo htmlspecialchars($pro_details['nom_pro']); ?></h1>
                <p><?php echo htmlspecialchars($adresse_details['numero']) . " " . htmlspecialchars($adresse_details['odonyme']); ?><br><?php echo htmlspecialchars($adresse_details['code_postal']) ?><br>France
                </p>
                <br>
                <p>SIRET : <?php echo htmlspecialchars($pro_details['num_siren']) ?></p>
            </div>
            <br>
        </div>
    </div>

    <hr>

    <!-- Informations Facture -->
    <div>
        <h1 class="text-2xl"><?php echo htmlspecialchars($offre['titre']) ?></h1>
        <br>
        <h1 class="text-xl">Facture N° <?php echo htmlspecialchars($numero); ?></h1>
        <p>Date d'émission : <?php echo htmlspecialchars($date_emission); ?></p>
        <p>Règlement : Le <?php echo $date_echeance ?> </p>
    </div>

    <!-- Détails pour les jours en ligne -->
    <div class="flex flex-col gap-2">
        <h2 class="text-xl">Jours en ligne</h2>

        <?php if (count($periodes_en_ligne) > 0) { ?>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-blue-200">
                    <tr>
                        <th class="border p-2">Type</th>
                        <th class="border p-2">Du<p class="text-small"> (inclus)</p>
                        </th>
                        <th class="border p-2">Au<p class="text-small"> (inclus)</p>
                        </th>
                        <th class="border p-2">Qte</th>
                        <th class="border p-2">Unité</th>
                        <th class="border p-2">Prix uni. HT</th>
                        <th class="border p-2">Total HT</th>
                        <th class="border p-2">TVA</th>
                        <th class="border p-2">Prix uni. TTC</th>
                        <th class="border p-2">Total TTC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($periodes_en_ligne as $periode_en_ligne) { ?>
                        <tr class="text-center">
                            <td class="border p-2"><?php echo htmlspecialchars($periode_en_ligne['type_offre']); ?></td>

                            <td class="border p-2">
                                <?php echo DateTime::createFromFormat('Y-m-d', $periode_en_ligne['date_debut'])->format('d/m/y') ?>
                            </td>
                            <td class="border p-2">
                                <?php echo DateTime::createFromFormat('Y-m-d', $periode_en_ligne['date_fin'])->format('d/m/y') ?>
                            </td>

                            <td class="border p-2 text-right"><?php echo $periode_en_ligne['duree'] ?></td>
                            <td class="border p-2 text-right"><?php echo 'jour' ?></td>

                            <td class="border p-2 text-right"><?php echo $periode_en_ligne['prix_ht'] ?> € </td>
                            <td class="border p-2 text-right"><?php echo $periode_en_ligne['prix_ht_total'] ?> €</td>

                            <!-- TVA -->
                            <td class="border p-2 text-right"><?php echo $periode_en_ligne['tva'] ?>%</td>

                            <td class="border p-2 text-right"><?php echo $periode_en_ligne['prix_ttc'] ?> €</td>
                            <td class="border p-2 text-right">
                                <?php echo $periode_en_ligne['prix_ttc_total'] ?> €
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aucun jour en ligne pour le mois actuel</p>
        <?php } ?>
    </div>

    <!-- Détails des options -->
    <div class="flex flex-col gap-2">
        <h2 class="text-xl">Options</h2>

        <?php if (count($options_details) > 0) { ?>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-blue-200">
                    <tr>
                        <th class="border p-2">Nom</th>
                        <th class="border p-2">Du<p class="text-small"> (inclus)</p>
                        </th>
                        <th class="border p-2">Au<p class="text-small"> (inclus)</p>
                        </th>
                        <th class="border p-2">Qte</th>
                        <th class="border p-2">Unité</th>
                        <th class="border p-2">Prix uni. HT</th>
                        <th class="border p-2">Total HT</th>
                        <th class="border p-2">TVA</th>
                        <th class="border p-2">Prix uni. TTC</th>
                        <th class="border p-2">Total TTC</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($options_details as $option_details) {
                        ?>
                        <tr>
                            <td class="border p-2"><?php echo htmlspecialchars($option_details['nom_option']); ?></td>
                            
                            <td class="border p-2 text-right"><?php echo DateTime::createFromFormat('Y-m-d', $option_details['date_lancement'])->format('d/m/y') ?></td>
                            <td class="border p-2 text-right"><?php echo DateTime::createFromFormat('Y-m-d', $option_details['date_fin'])->format('d/m/y') ?></td>

                            <td class="border p-2"><?php echo htmlspecialchars($option_details['nb_semaines']); ?></td>
                            <td class="border p-2 text-right"><?php echo 'semaine' ?></td>

                            <td class="border p-2 text-right"><?php echo $option_details['prix_ht'] ?> €</td>
                            <td class="border p-2 text-right"><?php echo $option_details['prix_ht_total'] ?> €</td>
                            <td class="border p-2 text-right"><?php echo $option_details['tva'] ?>%</td>
                            <td class="border p-2 text-right"><?php echo $option_details['prix_ttc'] ?> €</td>
                            <td class="border p-2 text-right"><?php echo $option_details['prix_ttc_total'] ?> €</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Aucune souscription à une option pour le mois actuel</p>
        <?php } ?>
    </div>

    <!-- Totaux globaux -->
    <div class="flex justify-end">
        <div class="w-1/3">
            <div class="flex justify-between">
                <span>Total HT</span>
                <span><?php echo number_format($type_offre['prix_ht'], 2) * $nbJoursEnLigne; ?> €</span>
            </div>
            <div class="flex justify-between">
                <span>TVA (<?php echo $TVA ?>%)</span>
                <span>
                    <?php echo (number_format($type_offre['prix_ht'], 2) * $nbJoursEnLigne) * ($TVA / 100) ?> €</span>
            </div>
            <div class="flex justify-between font-bold">
                <span>Total TTC</span>
                <span><?php echo (number_format($type_offre['prix_ht'], 2) * $nbJoursEnLigne) * (1 + ($TVA / 100)); ?>
                    €</span>
            </div>
        </div>
    </div>

    <hr>

    <!-- Mentions légales et coordonnées bancaires -->
    <div class="mt-10 text-sm text-center mt-10">
        <p>En cas de retard de paiement, une pénalité de 3 fois le taux d’intérêt légal sera appliquée, à
            laquelle s’ajoutera une indemnité forfaitaire de 40€.</p>
        <p>PACT</p>
    </div>

    <!-- Footer -->
    <div class="text-center text-sm">
        <p>Page 1/1</p>
    </div>
</div>