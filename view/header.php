<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../php_files/authentification.php';
if (isConnectedAsPro()) {
    ?>
        <!-- HEADER PRO -->
        <header class="w-full bg-white flex items-center px-4 h-16">
            <div class="flex w-full items-center justify-between relative mx-auto">
                <!-- Partie gauche -->
                <a href="/pro" class="flex gap-2 items-center">
                    <img src="/public/icones/logo.svg" alt="Logo de TripEnArvor : Moine macareux" width="50">
                    <h1 class="font-cormorant uppercase whitespace-nowrap text-PACT">
                        <span class="hidden md:inline">PACT</span> PRO
                    </h1>
                </a>

                <!-- Barre de recherche -->
                <div class="relative flex-1 max-w-lg mx-4">
                    <div class="w-full relative flex items-center">
                        <input type="text" id="search-field" placeholder="Rechercher par tags..."
                            class="rounded-full w-full border border-primary p-2 pl-10 pr-14 focus:outline-none focus:ring-2 focus:ring-primary transition duration-200"
                            aria-label="Recherche" autocomplete="off">
                        <div class="absolute right-4 flex items-center justify-center transform -translate-y-1/2">
                            <i class="fa-solid fa-magnifying-glass fa-lg cursor-pointer" id="search-btn"></i>
                        </div>
                        <!-- Bouton de suppression -->
                        <button class="hidden absolute right-2 min-w-max flex items-center justify-center bg-white  px-2 py-1"
                            id="clear-tags-btn">
                            <i class="text-xl fa-solid fa-times cursor-pointer"></i>
                        </button>
                    </div>
                    <!-- Dropdown de recherche -->
                    <div class="absolute top-full left-0 right-0 bg-white border border-base200  shadow-md mt-2 hidden z-10"
                        id="search-menu"></div>
                </div>

                <!-- Partie droite -->
                <div class="flex items-center gap-4">
                    <a href="/pro/compte">
                        <i class="text-3xl fa-regular fa-user"></i>
                    </a>
                </div>
            </div>
        </header>

<?php } else { ?>

        <!-- HEADER MEMBRE / VISITEUR -->
        <header class="flex items-center z-30 w-full bg-white px-4 h-16 top-0 mx-auto max-w-[1280px]">
            <div class="w-full flex items-center justify-between">
                <!-- Menu Burger pour les petits écrans -->
                <div class="flex items-center gap-4 md:hidden">
                    <button onclick="toggleMenu()">
                        <i class="text-3xl fa-solid fa-bars"></i>
                    </button>
                    <a href="/">
                        <img src="/public/icones/logo.svg" alt="Logo de TripEnArvor : Moine macareux" width="40">
                    </a>
                </div>

                <!-- Logo -->
                <a href="/" class="flex items-center gap-2">
                    <img src="/public/icones/logo.svg" alt="Logo de TripEnArvor : Moine macareux" width="50" class="hidden md:block">
                    <h1 class="font-cormorant uppercase text-PACT hidden md:block">PACT</h1>
                </a>

                <!-- Barre de recherche -->
                <div class="relative flex-1 max-w-lg mx-4">
                    <div class="relative flex items-center">
                        <input type="text" id="search-field" placeholder="Rechercher par tags..."
                            class="rounded-full w-full border border-primary p-2  pl-10 pr-14 focus:outline-none focus:ring-2 focus:ring-primary transition duration-200"
                            aria-label="Recherche" autocomplete="off">
                        <div class="absolute right-4 flex items-center justify-center transform -translate-y-1/2">
                            <i class="fa-solid fa-magnifying-glass fa-lg cursor-pointer" id="search-btn"></i>
                        </div>
                        <!-- Bouton de suppression -->
                        <button class="hidden absolute right-2 min-w-max flex items-center justify-center bg-white  px-2 py-1"
                            id="clear-tags-btn">
                            <i class="text-xl fa-solid fa-times cursor-pointer"></i>
                        </button>
                    </div>
                    <!-- Dropdown de recherche -->
                    <div class="absolute top-full left-0 right-0 bg-white border border-base200  shadow-md mt-2 hidden z-10"
                        id="search-menu"></div>
                </div>

                <!-- Actions Utilisateur -->
                <div class="flex items-center gap-4">
                    <?php require_once dirname($_SERVER['DOCUMENT_ROOT']) . '/php_files/authentification.php';
                    if (isConnectedAsMember()) { ?>
                            <!-- Si connecté -->
                            <a href="/compte">
                                <i class="text-3xl fa-regular fa-user"></i>
                            </a>
                            <a href="/scripts/logout.php" class="hidden md:block flex flex-col items-center"
                                onclick="return confirmLogout()">
                                <div class="text-black text-sm border border-secondary px-4 py-2 rounded-full">
                                    <p class="">Se déconnecter</p>
                                </div>
                            </a>
                    <?php } else { ?>
                            <!-- Si non connecté -->
                            <a href="/connexion" class="md:hidden">
                                <i class="text-3xl fa-regular fa-user"></i>
                            </a>
                            <a href="/connexion" class="hidden md:block">
                                <div
                                    class="text-white text-sm border border-secondary bg-secondary px-4 py-2 rounded-full hover:bg-secondary/90">
                                    <p class="">
                                        Se connecter</p>
                                </div>
                            </a>
                    <?php } ?>
                </div>
            </div>
        </header>
<?php } ?>