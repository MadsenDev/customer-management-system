<!-- Hamburger Button for mobile -->
<div class="md:hidden fixed top-0 right-0 z-50 p-4">
    <button id="menuBtn">
        <i class="fas fa-bars"></i>
    </button>
</div>

<!-- Menu for Desktop -->
<div class="w-1/7 h-screen bg-gray-800 text-white p-5 md:block hidden">
    <div class="mb-5">
        <img src="images/logo.png" alt="Logo" class="w-24 h-auto mx-auto">
    </div>
    <?php include 'menu_list.php'; ?>
</div>

<!-- Menu for Mobile -->
<div id="mobileMenu" class="fixed inset-0 bg-gray-800 text-white p-5 hidden flex flex-col justify-center items-center text-2xl">
    <!-- Close Button -->
    <button id="closeMenuBtn" class="self-end absolute top-4 right-4">
        <i class="fas fa-times"></i>
    </button>
    <!-- Menu List -->
    <div class="text-center">
        <?php include 'menu_list.php'; ?>
    </div>
</div>

<script>
    // Toggle Mobile Menu
document.getElementById('menuBtn').addEventListener('click', function() {
    document.getElementById('mobileMenu').classList.remove('hidden');
    document.getElementById('menuBtn').classList.add('hidden');  // Hide the hamburger menu
});
document.getElementById('closeMenuBtn').addEventListener('click', function() {
    document.getElementById('mobileMenu').classList.add('hidden');
    document.getElementById('menuBtn').classList.remove('hidden');  // Show the hamburger menu
});
</script>

<style>
    /* Hide desktop menu on mobile */
    @media (max-width: 1024px) {
        .menu {
            display: none;
        }
    }
    /* Larger text for mobile menu */
    #mobileMenu ul li a {
        font-size: 1.5rem;
    }
</style>
