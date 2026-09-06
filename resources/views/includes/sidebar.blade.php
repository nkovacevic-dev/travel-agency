<a href="{{ url('/') }}">
    <img src="{{ asset('images/logo-sidebar2.png') }}" class="logo" alt="Logo">
</a>
<ul class="sidebar-menu">
     <li class="sidebar-item has-submenu">
         <a href="#submenu1" class="sidebar-link">
             <span class="sidebar-icon fa fa-plane"></span>
             <span class="sidebar-text">Putovanja</span>
             <span class="submenu-arrow fa fa-angle-down"></span> <!-- strelica uvek vidljiva -->
         </a>
         <ul id="submenu1" class="sidebar-submenu">
             <li><a href="{{ route('putovanja.create') }}" class="sidebar-link">Unos</a></li>
             <li><a href="{{ route('putovanja.index') }}" class="sidebar-link">Lista</a></li>
         </ul>
     </li>

     <li class="sidebar-item has-submenu">
         <a href="#submenu2" class="sidebar-link">
             <span class="sidebar-icon fa fa-pencil"></span>
             <span class="sidebar-text">Rezervacije</span>
             <span class="submenu-arrow fa fa-angle-down"></span>
         </a>
         <ul id="submenu2" class="sidebar-submenu">
             <li><a href="{{ route('rezervacije.create') }}" class="sidebar-link">Unos</a></li>
             <li><a href="{{ route('rezervacije.index') }}" class="sidebar-link">Lista</a></li>
         </ul>
     </li>
     <li class="sidebar-item has-submenu">
         <a href="#submenu3" class="sidebar-link">
             <span class="sidebar-icon fa fa-bed"></span>
             <span class="sidebar-text">Hoteli</span>
             <span class="submenu-arrow fa fa-angle-down"></span>
         </a>
         <ul id="submenu3" class="sidebar-submenu">
             <li><a href="{{ route('hoteli.create') }}" class="sidebar-link">Unos</a></li>
             <li><a href="{{ route('hoteli.index') }}" class="sidebar-link">Lista</a></li>
         </ul>
     </li>

     <li class="sidebar-item has-submenu">
         <a href="#submenu4" class="sidebar-link">
             <span class="sidebar-icon fa fa-users"></span>
             <span class="sidebar-text">Korisnici</span>
             <span class="submenu-arrow fa fa-angle-down"></span>
         </a>
         <ul id="submenu4" class="sidebar-submenu">
             <li><a href="{{ route('korisnici.create') }}" class="sidebar-link">Unos</a></li>
             <li><a href="{{ route('korisnici.index') }}" class="sidebar-link">Lista</a></li>
         </ul>
     </li>

     <li class="sidebar-item sidebar-collapse">
         <a href="#" id="collapse-btn" class="sidebar-link">
             <span class="sidebar-icon fa fa-2x"></span>
         </a>
     </li>

</ul>

 <script>
     $(document).ready(function() {
         // Hide all submenus initially
         $('.sidebar-submenu').hide();

         // Toggle submenu on click
         $('.has-submenu > .sidebar-link').click(function(e) {
             e.preventDefault();
             var parentLi = $(this).parent();

             $(this).next('.sidebar-submenu').slideToggle();
             parentLi.toggleClass('open'); // rotacija strelice

             // Obeleži aktivan meni
             $('.sidebar-item').not(parentLi).removeClass('active'); // ukloni sa ostalih
             parentLi.addClass('active');
         });

         // Kada se klikne na običan link (bez submenija)
         $('.sidebar-item > .sidebar-link').not('.has-submenu > .sidebar-link').click(function() {
             $('.sidebar-item').removeClass('active'); // ukloni aktivne klase
             $(this).parent().addClass('active'); // označi kliknuti
         });

         // Collapse sidebar
         $('#collapse-btn').click(function(e) {
             e.preventDefault();
             $('#sidebar-container').toggleClass('sidebar-expanded sidebar-collapsed');
             $('.sidebar-text').toggle();
             if ($('#sidebar-container').hasClass('sidebar-collapsed')) {
                 $('.sidebar-submenu').hide();
                 $('.has-submenu').removeClass('open'); // ukloni rotaciju strelice
             }
         });

         $('#mobile-sidebar-btn').click(function() {
             $('#sidebar-container').toggleClass('mobile-open');
         });

         $('.sidebar-submenu .sidebar-link').click(function() {
             $('#sidebar-container').removeClass('mobile-open');
         });
     });
 </script>