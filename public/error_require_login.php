<br>

<style>
    @media (max-width: 480px) {
        h3 {
            font-size: 1.2rem;
        }
    }
    @media (max-width: 670px) {
        .reduceIfNeeded {
            width: 70% !important;
        }
    }
    @media (min-width: 671px) {
        .reduceIfNeeded {
            width: 50% !important;
        }
    }
  </style>

<div class="box container text-center reduceIfNeeded">
    <h3>You must be logged in!</h3>
    <p>To access this section</p>
    <br>
    <a class="btn btn-success" href="/login?redirect=<?php echo parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>">Log in</a>
</div>