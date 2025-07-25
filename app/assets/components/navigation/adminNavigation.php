<?php
$activeClass = "activeNavigation";

// Pfad extrahieren (z. B. editor aus /admin/editor)
$Request_URI = explode('/', trim($_SERVER["REQUEST_URI"], '/'));

// Standardmäßig kein aktiver Wert
$activeNavId = isset($Request_URI[1]) ? $Request_URI[1] : 'dashboard';
?>


<nav id="sidebar" class="Sidebar h-full bg-white fixed left-0 top-0 p-5 flex flex-col gap-6 sidebar-closed z-50">

    <!-- Chevron Toggle Button -->
    <button onclick="toggleSidebar()" class="absolute -right-3 top-10 z-50 rounded-full phaedra-primary-backgroundcolor w-[30px] h-[30px] shadow-md cursor-pointer">
        <i id="chevronIcon" class="fa-solid fa-chevron-right transition-transform duration-300"></i>
    </button>

    <!-- Logo -->
    <div class="flex gap-5 items-center">
        <div class="h-[50px] w-[50px] phaedra-primary-backgroundcolor flex items-center justify-center rounded-md">
            <i class="fa-solid fa-cloud text-2xl"></i>
        </div>
        <h1 class="text-3xl font-semibold phaedra-primary-color navLabel">Phaedra</h1>
    </div>

    <hr class="phaedra-primary-color">

    <!-- Navigation -->
    <div class="pl-2 flex flex-col gap-5">
        <a href="/admin" class="flex flex-row gap-5 items-center nav-link" data-nav-id="dashboard">
            <div class="h-[30px] w-[30px] phaedra-primary-color flex items-center justify-center rounded-md p-5 <?= $activeNavId === 'dashboard' ? $activeClass : '' ?>">
                <i class="fa-solid fa-chart-simple text-3xl"></i>
            </div>
            <h2 class="text-2xl phaedra-primary-color navLabel">Dashboard</h2>
        </a>
        <a href="/admin/editor" class="flex flex-row gap-5 items-center nav-link" data-nav-id="editor">
            <div class="h-[30px] w-[30px] phaedra-primary-color flex items-center justify-center rounded-md p-5 <?= $activeNavId === 'editor' ? $activeClass : '' ?>">
                <i class="fa-regular fa-newspaper text-3xl"></i>
            </div>
            <h2 class="text-2xl phaedra-primary-color navLabel">Site-Editor</h2>
        </a>
        <a href="/admin/folders" class="flex flex-row gap-5 items-center nav-link" data-nav-id="folders">
            <div class="h-[30px] w-[30px] phaedra-primary-color flex items-center justify-center rounded-md p-5 <?= $activeNavId === 'folders' ? $activeClass : '' ?>">
                <i class="fa-solid fa-folder-open text-3xl"></i>
            </div>
            <h2 class="text-2xl phaedra-primary-color navLabel">Dateimanager</h2>
        </a>
        <a href="/admin/settings" class="flex flex-row gap-5 items-center nav-link" data-nav-id="settings">
            <div class="h-[30px] w-[30px] phaedra-primary-color flex items-center justify-center rounded-md p-5 <?= $activeNavId === 'settings' ? $activeClass : '' ?>">
                <i class="fa-solid fa-gears text-3xl"></i>
            </div>
            <h2 class="text-2xl phaedra-primary-color navLabel">Einstellungen</h2>
        </a>
        <a href="/admin/userprofile" class="flex flex-row gap-5 items-center nav-link" data-nav-id="userprofile">
            <div class="h-[30px] w-[30px] phaedra-primary-color flex items-center justify-center rounded-md p-5 <?= $activeNavId === 'userprofile' ? $activeClass : '' ?>">
                <i class="fa-solid fa-key text-3xl"></i>
            </div>
            <h2 class="text-2xl phaedra-primary-color navLabel">Profil</h2>
        </a>
    </div>

    <hr class="phaedra-primary-color">

    <!-- Widget Navigation -->
    <div class="pl-2 flex flex-col gap-5">
        <a href="/admin/timeline" class="flex flex-row gap-5 items-center nav-link" data-nav-id="timeline">
            <div class="h-[30px] w-[30px] phaedra-primary-color flex items-center justify-center rounded-md p-5 <?= $activeNavId === 'timeline' ? $activeClass : '' ?>">
                <i class="fa-solid fa-timeline text-3xl"></i>
            </div>
            <h2 class="text-2xl phaedra-primary-color navLabel">Timeline</h2>
        </a>
        <a href="/admin/socials" class="flex flex-row gap-5 items-center nav-link" data-nav-id="socials">
            <div class="h-[30px] w-[30px] phaedra-primary-color flex items-center justify-center rounded-md p-5 <?= $activeNavId === 'socials' ? $activeClass : '' ?>">
                <i class="fa-solid fa-share-nodes text-3xl"></i>
            </div>
            <h2 class="text-2xl phaedra-primary-color navLabel">Socials</h2>
        </a>
        <a href="/admin/faq" class="flex flex-row gap-5 items-center nav-link" data-nav-id="faq">
            <div class="h-[30px] w-[30px] phaedra-primary-color flex items-center justify-center rounded-md p-5 <?= $activeNavId === 'faq' ? $activeClass : '' ?>">
                <i class="fa-solid fa-comments text-3xl"></i>
            </div>
            <h2 class="text-2xl phaedra-primary-color navLabel">FAQ</h2>
        </a>
    </div>

    <hr class="phaedra-primary-color">

    <!-- Logout -->
    <a href="/api/login/logout.php" class="flex flex-row gap-5 pl-2 items-center nav-link" data-nav-id="logout">
        <div class="h-[30px] w-[30px] phaedra-primary-color flex items-center justify-center rounded-md p-5">
            <i class="fa-solid text-3xl fa-right-from-bracket"></i>
        </div>
        <h2 class="text-2xl phaedra-primary-color navLabel">Abmelden</h2>
    </a>

</nav>

<!-- JavaScript -->
<script>
    let isSidebarOpen = false;

    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const chevron = document.getElementById("chevronIcon");

        isSidebarOpen = !isSidebarOpen;

        if (isSidebarOpen) {
            sidebar.classList.add("sidebar-open");
            sidebar.classList.remove("sidebar-closed");
            chevron.classList.add("rotate-180");
        } else {
            sidebar.classList.add("sidebar-closed");
            sidebar.classList.remove("sidebar-open");
            chevron.classList.remove("rotate-180");
        }
    }
</script>