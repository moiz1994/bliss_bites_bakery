<?php
// ============ FOOTER INCLUDE ============
// Contains closing tags for page content, main content, and scripts
?>
</div><!-- End page-content -->
</main><!-- End main-content -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="../assets/js/main.js"></script>

<script>
  // ============ SIDEBAR TOGGLE ============
  const sidebar = document.getElementById('sidebar');
  const mainContent = document.getElementById('mainContent');
  const toggleBtn = document.getElementById('toggleSidebar');
  const overlay = document.getElementById('sidebarOverlay');

  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      if (window.innerWidth > 991) {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
      } else {
        sidebar.classList.toggle('mobile-show');
        overlay.classList.toggle('show');
      }
    });
  }

  if (overlay) {
    overlay.addEventListener('click', () => {
      sidebar.classList.remove('mobile-show');
      overlay.classList.remove('show');
    });
  }

  window.addEventListener('resize', () => {
    if (window.innerWidth > 991) {
      overlay.classList.remove('show');
      sidebar.classList.remove('mobile-show');
    }
  });
</script>

</body>

</html>