<!-- Overlay para móvil -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden transition-opacity duration-300 opacity-0"></div>

<script>
(function() {
    'use strict';
    
    function initSidebar() {
        const sidebar = document.getElementById('logo-sidebar');
        const toggleBtn = document.getElementById('sidebar-toggle-header');
        const overlay = document.getElementById('sidebar-overlay');
        
        if (!sidebar) {
            console.error('Sidebar element not found');
            return;
        }
        
        console.log('Overlay Sidebar initialized for Secretaría');
        
        // Event listener para el botón toggle (siempre abre/cierra overlay)
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                toggleSidebar();
            });
        }
        
        // Cerrar sidebar al hacer click en el overlay
        if (overlay) {
            overlay.addEventListener('click', function() {
                closeSidebar();
            });
        }
        
        // Cerrar sidebar al hacer click en un link
        if (sidebar) {
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    closeSidebar();
                });
            });
        }
        
        // Cerrar sidebar con tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSidebar();
            }
        });
        
        // Función para toggle del sidebar (overlay)
        function toggleSidebar() {
            const isOpen = !sidebar.classList.contains('-translate-x-full');
            
            if (isOpen) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }
        
        // Abrir sidebar
        function openSidebar() {
            console.log('Opening overlay sidebar');
            sidebar.classList.remove('-translate-x-full');
            if (overlay) {
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                }, 10);
            }
            document.body.style.overflow = 'hidden';
        }
        
        // Cerrar sidebar
        function closeSidebar() {
            console.log('Closing overlay sidebar');
            sidebar.classList.add('-translate-x-full');
            if (overlay) {
                overlay.classList.add('opacity-0');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                }, 300);
            }
            document.body.style.overflow = '';
        }
    }
    
    // Ejecutar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebar);
    } else {
        initSidebar();
    }
})();
</script>

<style>
    /* Asegurar que el overlay esté por encima del contenido pero debajo del sidebar */
    #sidebar-overlay {
        z-index: 30;
    }
    
    #logo-sidebar {
        z-index: 40;
    }
    
    /* Animación suave del overlay */
    #sidebar-overlay {
        transition: opacity 300ms cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Asegurar que el sidebar tenga la transición correcta */
    #logo-sidebar {
        transition: transform 300ms cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Prevenir interacción con el contenido cuando el sidebar está abierto */
    body:has(#logo-sidebar:not(.-translate-x-full)) {
        overflow: hidden;
    }
</style>
