<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Brand</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <?php if($_SESSION['type'] == 'Gebruiker' or $_SESSION['type'] == 'Beheerder' ){ ?>
        <li><a href="index.php">Eigen nummerborden<span class="sr-only">(current)</span></a></li>
        <?php } ?> 
        <?php if($_SESSION['type'] == 'Admin'){ ?>
        <li><a href="index.php">Steden</a></li>
        <li><a href="/admin/admins.php">Admins</a></li>
        <?php }
        if($_SESSION['type'] == 'Beheerder') { ?>
        <li><a href="/beheerder/gebruikers.php">Gebruikers</a></li>
        <li><a href="/beheerder/toezichthouder.php">Aangemelde nummerborden</a></li>
        <?php }
        if($_SESSION['type'] == 'Gebruiker' or $_SESSION['type'] == 'Beheerder' ){ ?>
        <li><a href="/logboek.php">Logboek<span class="sr-only">(current)</span></a></li>
        <?php }
        if($_SESSION['type'] == 'Toezichthouder'){ ?>
        <li><a href="/toezichthouder/index.php">Nummerborden</a></li>
        <li><a href="/logboek.php">Logboek</a></li>
        <?php } ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/profiel.php"><?php echo $_SESSION['name']?></a></li>
        <li><a href="/logout.php">Logout</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>