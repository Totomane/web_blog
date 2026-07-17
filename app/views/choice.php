<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/layout/header.php';
?>

<!-- Section Hero / Interactive Menu Accordion (Full Screen Experience) -->
<div class="w-full h-[calc(100vh-90px)] min-h-[600px] bg-[#f5f1eb] flex flex-col pt-8 pb-0 px-0 transition-colors duration-500">
    <div class="w-full px-6 md:px-12 mb-6 flex flex-col flex-none justify-start items-start md:items-center">
        <h1 class="text-sm md:text-base font-medium text-[#1a1a1a] uppercase tracking-[0.25em]">Choisissez une catégorie pour explorer nos projets.</h1>
    </div>
    
    <div class="flex flex-col flex-1 md:flex-row w-full h-full max-w-full mx-auto gap-1 md:gap-2 group/accordion">
        
        <!-- Card 1 : Villa -->
        <a href="index.php?action=projects&category=Villa" class="relative flex-1 flex md:flex-1 items-center justify-center overflow-hidden transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] hover:flex-[4] md:hover:flex-[4] group/card bg-[#eae3d8]">
            <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1600&q=80" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60 transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-90 group-hover/card:scale-105" 
                 alt="Villa">
            <div class="relative z-10 flex flex-col items-center justify-center p-6 w-full h-full">
                <h2 class="text-[#1a1a1a] text-xl md:text-3xl font-bold uppercase tracking-[0.3em] transition-transform duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:-translate-y-6">Villa</h2>
                <div class="absolute opacity-0 transform translate-y-6 transition-all duration-700 delay-100 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-100 group-hover/card:translate-y-4 text-center w-full px-4 max-w-[300px]">
                    <p class="text-neutral-800 text-xs md:text-sm font-light tracking-wide leading-relaxed">Résidences privées d'exception, design et confort.</p>
                </div>
            </div>
            <div class="absolute -bottom-8 -right-4 md:-bottom-12 md:-right-6 text-[10rem] md:text-[20rem] font-bold text-[#1a1a1a] opacity-0 group-hover/card:opacity-[0.03] transition-opacity duration-700 pointer-events-none leading-none select-none z-0">1</div>
            <div class="absolute bottom-10 w-[1px] h-16 bg-[#1a1a1a]/20 transition-opacity duration-300 group-hover/card:opacity-0 hidden md:block"></div>
        </a>

        <!-- Card 2 : Appartement -->
        <a href="index.php?action=projects&category=Appartement" class="relative flex-1 flex md:flex-1 items-center justify-center overflow-hidden transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] hover:flex-[4] md:hover:flex-[4] group/card bg-[#eae3d8]">
            <img src="https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1600&q=80" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60 transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-90 group-hover/card:scale-105 saturate-50 group-hover/card:saturate-100" 
                 alt="Appartement">
            <div class="relative z-10 flex flex-col items-center justify-center p-6 w-full h-full">
                <h2 class="text-[#1a1a1a] text-xl md:text-3xl font-bold uppercase tracking-[0.3em] transition-transform duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:-translate-y-6">Appartement</h2>
                <div class="absolute opacity-0 transform translate-y-6 transition-all duration-700 delay-100 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-100 group-hover/card:translate-y-4 text-center w-full px-4 max-w-[300px]">
                    <p class="text-neutral-800 text-xs md:text-sm font-light tracking-wide leading-relaxed">Aménagements d'intérieurs urbains esthétiques.</p>
                </div>
            </div>
            <div class="absolute -bottom-8 -right-4 md:-bottom-12 md:-right-6 text-[10rem] md:text-[20rem] font-bold text-[#1a1a1a] opacity-0 group-hover/card:opacity-[0.03] transition-opacity duration-700 pointer-events-none leading-none select-none z-0">2</div>
            <div class="absolute bottom-10 w-[1px] h-16 bg-[#1a1a1a]/20 transition-opacity duration-300 group-hover/card:opacity-0 hidden md:block"></div>
        </a>

        <!-- Card 3 : Hôtel -->
        <a href="index.php?action=projects&category=Hotel" class="relative flex-1 flex md:flex-1 items-center justify-center overflow-hidden transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] hover:flex-[4] md:hover:flex-[4] group/card bg-[#eae3d8]">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600&q=80" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60 transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-90 group-hover/card:scale-105 saturate-50 group-hover/card:saturate-100" 
                 alt="Hôtel">
            <div class="relative z-10 flex flex-col items-center justify-center p-6 w-full h-full">
                <h2 class="text-[#1a1a1a] text-xl md:text-3xl font-bold uppercase tracking-[0.3em] transition-transform duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:-translate-y-6">Hôtel</h2>
                <div class="absolute opacity-0 transform translate-y-6 transition-all duration-700 delay-100 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-100 group-hover/card:translate-y-4 text-center w-full px-4 max-w-[300px]">
                    <p class="text-neutral-800 text-xs md:text-sm font-light tracking-wide leading-relaxed">Conception d'espaces de réception prestigieux.</p>
                </div>
            </div>
            <div class="absolute -bottom-8 -right-4 md:-bottom-12 md:-right-6 text-[10rem] md:text-[20rem] font-bold text-[#1a1a1a] opacity-0 group-hover/card:opacity-[0.03] transition-opacity duration-700 pointer-events-none leading-none select-none z-0">3</div>
            <div class="absolute bottom-10 w-[1px] h-16 bg-[#1a1a1a]/20 transition-opacity duration-300 group-hover/card:opacity-0 hidden md:block"></div>
        </a>

        <!-- Card 4 : Bâtiment -->
        <a href="index.php?action=projects&category=Batiment" class="relative flex-1 flex md:flex-1 items-center justify-center overflow-hidden transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] hover:flex-[4] md:hover:flex-[4] group/card bg-[#eae3d8]">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1600&q=80" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60 transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-90 group-hover/card:scale-105 saturate-50 group-hover/card:saturate-100" 
                 alt="Bâtiment">
            <div class="relative z-10 flex flex-col items-center justify-center p-6 w-full h-full">
                <h2 class="text-[#1a1a1a] text-xl md:text-3xl font-bold uppercase tracking-[0.3em] transition-transform duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:-translate-y-6">Bâtiment</h2>
                <div class="absolute opacity-0 transform translate-y-6 transition-all duration-700 delay-100 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-100 group-hover/card:translate-y-4 text-center w-full px-4 max-w-[300px]">
                    <p class="text-neutral-800 text-xs md:text-sm font-light tracking-wide leading-relaxed">Projets monumentaux et structures modernes emblématiques.</p>
                </div>
            </div>
            <div class="absolute -bottom-8 -right-4 md:-bottom-12 md:-right-6 text-[10rem] md:text-[20rem] font-bold text-[#1a1a1a] opacity-0 group-hover/card:opacity-[0.03] transition-opacity duration-700 pointer-events-none leading-none select-none z-0">4</div>
            <div class="absolute bottom-10 w-[1px] h-16 bg-[#1a1a1a]/20 transition-opacity duration-300 group-hover/card:opacity-0 hidden md:block"></div>
        </a>

        <!-- Card 5 : Tous les projets -->
        <a href="index.php?action=projects" class="relative flex-1 flex md:flex-1 items-center justify-center overflow-hidden transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] hover:flex-[4] md:hover:flex-[4] group/card bg-[#eae3d8]">
            <img src="https://images.unsplash.com/photo-1449844908441-8829872d2607?w=1600&q=80" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60 transition-all duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-90 group-hover/card:scale-105 saturate-50 group-hover/card:saturate-100" 
                 alt="Tous les projets">
            <div class="relative z-10 flex flex-col items-center justify-center p-6 w-full h-full">
                <h2 class="text-[#1a1a1a] text-xl md:text-3xl font-bold text-center uppercase tracking-[0.3em] transition-transform duration-700 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:-translate-y-6 leading-relaxed">Tous les<br>projets</h2>
                <div class="absolute opacity-0 transform translate-y-6 transition-all duration-700 delay-100 ease-[cubic-bezier(0.25,1,0.5,1)] group-hover/card:opacity-100 group-hover/card:translate-y-4 text-center w-full px-4 max-w-[300px]">
                    <p class="text-neutral-800 text-xs md:text-sm font-light tracking-wide leading-relaxed">Explorer l'intégralité de notre portfolio.</p>
                </div>
            </div>
            <div class="absolute -bottom-8 -right-4 md:-bottom-12 md:-right-6 text-[10rem] md:text-[20rem] font-bold text-[#1a1a1a] opacity-0 group-hover/card:opacity-[0.03] transition-opacity duration-700 pointer-events-none leading-none select-none z-0">5</div>
            <div class="absolute bottom-10 w-[1px] h-16 bg-[#1a1a1a]/20 transition-opacity duration-300 group-hover/card:opacity-0 hidden md:block"></div>
        </a>

    </div>
</div>

<?php
include __DIR__ . '/layout/scripts.php';
?>
