
<?php
    include("../php/authentification.php");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/output.css">
    <script type="module" src="/scripts/main.js" defer></script>
    <title>PACT - Accueil</title>
</head>
<body class="flex flex-col min-h-screen">

    <div id="header" class="mb-10"></div>
    
    <!-- VERSION TELEPHONE -->
    <main class="phone md:hidden grow p-4 flex flex-col gap-4">
        <div id="menu" class="2"></div>
        
        <h1 class="text-4xl">Toutes les offres</h1>

        <!--
        ### CARD COMPONENT ! ###
        Composant dynamique (généré avec les données en php)
        Impossible d'en faire un composant pur (statique), donc écrit en HTML pur (copier la forme dans le php)
        -->
        <a href="/pages/details.php">
            <div class="card active relative bg-base200 rounded-xl flex flex-col">
                <!-- En tête -->
                <div class="en-tete absolute top-0 w-72 max-w-full bg-bgBlur/75 backdrop-blur left-1/2 -translate-x-1/2 rounded-b-lg">
                    <h3 class="text-center font-bold">Restaurant le Brélévenez</h3>
                    <div class="flex w-full justify-between px-2">
                        <p class="text-small">Le brélévenez</p>
                        <p class="text-small">Restauration</p>
                    </div>
                </div>
                <!-- Image de fond -->
                <img class="h-48 w-full rounded-t-lg object-cover" src="../public/images/image-test.jpg" alt="Image promotionnelle de l'offre">
                <!-- Infos principales -->
                <div class="infos flex items-center justify-center gap-2 px-2 grow">
                    <!-- Localisation -->
                    <div class="localisation flex flex-col gap-2 flex-shrink-0 justify-center items-center">
                        <i class="fa-solid fa-location-dot"></i>
                        <p class="text-small">Lannion</p>
                        <p class="text-small">22300</p>
                    </div>
                    <hr class="h-20 border-black border">
                    <!-- Description -->
                    <div class="description py-2 flex flex-col gap-2 justify-center self-stretch">
                        <div class="p-1 rounded-lg bg-secondary self-center">
                            <p class="text-white text-center text-small font-bold">Petit déjeuner, Dîner, Boissons</p>
                        </div>
                        <p class="overflow-hidden line-clamp-2 text-small">
                            Priscilla en salle, son mari Christophe chef de cuisine et toute l'équipe vous accueillent dans leur restaurant, Ouvert depuis Janvier 2018, dans le quartier Historique De Lannion :" Brélévenez"
                            Quartier célèbre pour son église avec son escalier de 142 marches pour y accéder.
                            Christophe vous propose une cuisine de produits locaux et de saisons.
                            Restaurant ouvert à l'année.
                            Fermé mardi et mercredi toute la journée et le samedi midi.
                            (Parking privé)
                        </p>
                    </div>
                    <hr class="h-20 border-black border">
                    <!-- Notation et Prix -->
                    <div class="localisation flex flex-col flex-shrink-0 gap-2 justify-center items-center">
                        <p class="text-small">€€</p>
                    </div>
                </div>
            </div>
        </a>
    </main>
    
    <!-- VERSION TABLETTE -->
    <main class="hidden md:block grow mx-10 self-center rounded-lg p-2 max-w-[1280px]">
        <div class="flex gap-3">
            <!-- PARTIE GAUCHE (menu) -->
            <div id="menu" class="2"></div>

            <!-- PARTIE DROITE (offre & détails) -->
            <div class="tablette p-4 flex flex-col gap-4">
            
                <h1 class="text-4xl">Toutes les offres</h1>
        
                <!--
                ### CARD COMPONENT ! ###
                Composant dynamique (généré avec les données en php)
                Impossible d'en faire un composant pur (statique), donc écrit en HTML pur (copier la forme dans le php)
                -->
                <a href="/pages/details.php">
                    <div class="card active relative bg-base200 rounded-lg flex">
                        <!-- Partie gauche -->
                        <div class="gauche grow relative shrink-0 basis-1/2 h-[280px] overflow-hidden">
                            <!-- En tête -->
                            <div class="en-tete absolute top-0 w-72 max-w-full bg-bgBlur/75 backdrop-blur left-1/2 -translate-x-1/2 rounded-b-lg">
                                <h3 class="text-center font-bold">Restaurant le Brélévenez</h3>
                                <div class="flex w-full justify-between px-2">
                                    <p class="text-small">Le brélévenez</p>
                                    <p class="text-small">Restauration</p>
                                </div>
                            </div>
                            <!-- Image de fond -->
                            <img class="rounded-l-lg w-full h-full object-cover object-center" src="../public/images/image-test.jpg" alt="Image promotionnelle de l'offre">
                        </div>
                        <!-- Partie droite (infos principales) -->
                        <div class="infos flex flex-col items-center p-3 gap-3 justify-between">
                            <!-- Description -->
                            <div class="description py-2 flex flex-col gap-2">
                                <div class="p-1 rounded-lg bg-secondary self-center">
                                    <p class="text-white text-center text-small font-bold">Petit déjeuner, Dîner, Boissons</p>
                                </div>
                                <p class="overflow-hidden line-clamp-5 text-small">
                                    Priscilla en salle, son mari Christophe chef de cuisine et toute l'équipe vous accueillent dans leur restaurant, Ouvert depuis Janvier 2018, dans le quartier Historique De Lannion :" Brélévenez"
                                    Quartier célèbre pour son église avec son escalier de 142 marches pour y accéder.
                                    Christophe vous propose une cuisine de produits locaux et de saisons.
                                    Restaurant ouvert à l'année.
                                    Fermé mardi et mercredi toute la journée et le samedi midi.
                                    (Parking privé)
                                </p>
                            </div>
                            <!-- A droite, en bas -->
                            <div class="self-stretch flex flex-col gap-2">
                                <hr class="border-black w-full">
                                <div class="flex justify-around self-stretch">
                                    <!-- Localisation -->
                                    <div class="localisation flex flex-col gap-2 flex-shrink-0 justify-center items-center">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <p class="text-small">Lannion</p>
                                        <p class="text-small">22300</p>
                                    </div>
                                    <!-- Notation et Prix -->
                                    <div class="localisation flex flex-col flex-shrink-0 gap-2 justify-center items-center">
                                        <p class="text-small">€€</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </main>

    <div id="footer"></div>
    
</body>
</html>
