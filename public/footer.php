
    <script src="/public/scripts/auth.js"></script>

    <script>
    <?php
      if (isset($_SESSION['user_id'])) {
          $response = array();
          $response['user_id'] = $_SESSION['user_id'];
          $response['username'] = $_SESSION['username'];
          $response['fullname'] = $_SESSION['fullname'];
          $response['email'] = $_SESSION['email'];
          $session_info = json_encode($response);
          echo "loadSessionDetails('$session_info');";
          if ($_SESSION['admin']) {
            echo "$('.show-if-admin').show();";
          }
      }
      else {
          echo "$('.show-if-not-logged').show();";
      }
    ?>
    </script>

    <!-- Footer -->
    <footer class="text-center text-lg-start page-footer text-muted">

      <div class="text-center mt-4 p-4" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2023 MiWiki (LTW Project)
      </div>
      <!-- Copyright -->
    </footer>
    <!-- Footer -->

</body>
</html>