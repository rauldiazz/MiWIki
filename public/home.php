
<?php
    $title = "Home";
    session_start();
    include("header.php");
?>

<link rel="stylesheet" type="text/css" href="/public/styles/home.css">

<div class="container-fluid">
  <div class="row">

    <div id="first-col" class="col-md">
      <div class="box">
        <h2>Welcome to MiWiki!</h2>
        <hr>
        <p>
          On this website, you can create your own custom wiki and save as many articles as you wish to your local disk.
          <br>
          Our goal is to provide you with an easy and accessible platform to document and organise your ideas and thoughts, as well as to share your knowledge with others.
        </p>
        <p>
          On MiWiki, you have the freedom to write on any topic that interests you, from technology and science to art and culture.
          You can also translate your articles into different languages, export them in a variety of formats and share them with your friends and colleagues.
        </p>
        <p>Explore all that MiWiki has to offer and create your own personalised knowledge base today!</p>
      </div>
    </div>

    <div id="second-col" class="col-md">
      <div class="box d-flex align-items-center justify-content-center">
        <div class="search-box text-center">
          <h3>Search</h3> 
          <form action="/search" method="get">
            <div class="input-group mb-3">
              <input id="search-bar" type="text" name="q" class="form-control dark-input" placeholder="Search for a page title" aria-label="" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn dark-input" type="submit" id="search-btn">
                  <i class="bi bi-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="box">
        <div class="show-if-logged" style="display:none">
          <h3>Welcome, <b class="session-username"></b></h3>
          <hr> 
          <a href="/my_account" class="btn btn-secondary">My account</a>
          <a href="/new" class="btn btn-info ml-2">Create new page</a>
        </div>
        <div class="show-if-not-logged" style="display:none">
          <h3>Log in</h3>
          <hr>
          <form class="text-left" id="login-form" onsubmit="login(event, loadSessionDetails)">
              <div class="form-group">
                  <label for="usernameInp">Username</label>
                  <input type="text" class="form-control dark-input" id="usernameInp" placeholder="Username" required>
              </div>
              <div class="form-group">
                  <label for="passwordInp">Password</label>
                  <div class="input-group">
                        <input type="password" class="form-control dark-input" id="passwordInp" placeholder="Password" required>
                        <button class="btn btn-outline-secondary password-eye" type="button" id="passwordInpToggleBtn" onclick="togglePasswordVisibility('passwordInp')">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
              <br>
              <div class="form-inline">
                  <button type="submit" class="btn btn-success my-auto">Log in</button>
                  <div class="auth-loading spinner-border ml-2" role="status" style="display: none">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <div class="alert alert-danger ml-auto my-auto" role="alert" id="login-error" style="display:none"></div>
                  <a class="btn btn-secondary my-auto ml-auto" href="/signup">Sign up</a>
              </div>
          </form>
        </div>
      </div>

      <div class="box">
        <h3>Number of pages in MiWiki: <?php echo numberOfPages();?></h3>
        <hr>
        <a href="/random" class="btn btn-dark">Random page</a>
      </div>

    </div>

  </div>
</div>

<script src="/public/scripts/passwordVisibility.js"></script>

<?php include("footer.php") ?>