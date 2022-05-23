<!-- ######################     Main Navigation   ########################## -->
<nav class="navbar navbar-expand-md navbar-light" style="background-color: darkseagreen">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            VTSRC Referee Mentoring
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="text-align: center">
                <?php
                // This sets a class for current page so you can style it differently

                print '<li class = "nav-item"';
                if (PATH_PARTS['filename'] == 'index') {
                    print '><a class="nav-link active" href="index.php">Home</a></li>';
                }
                else {
                    print '><a class="nav-link" href="index.php">Home</a></li>';
                }


                print '<li class = "nav-item"';
                if (PATH_PARTS['filename'] == 'addFirst') {
                    print '><a class="nav-link active" href="addFirst.php">Enter Reports</a></li>';
                }
                else {
                    print '><a class="nav-link " href="addFirst.php">Enter Reports</a></li>';
                }

                print '<li class = "nav-item"';
                if (PATH_PARTS['filename'] == 'lookup') {
                    print '><a class="nav-link active" href="lookup.php">Lookup Reports</a></li>';
                }
                else {
                    print '><a class="nav-link" href="lookup.php">Lookup Reports</a></li>';
                }

                print '<li class = "nav-item"';
                if (PATH_PARTS['filename'] == 'other') {
                    print '><a class="nav-link active" href="other.php">Other Info/Payment</a></li>';
                }
                else {
                    print '><a class="nav-link" href="other.php">Other Info/Payment</a></li>';
                }

                print '<li class = "nav-item"';
                if (PATH_PARTS['filename'] == 'authenticate' or PATH_PARTS['filename'] == 'assignor') {
                    print '><a class="nav-link active" href="authenticate.php">Assignors</a></li>';
                }
                else {
                    print '><a class="nav-link" href="authenticate.php">Assignors</a></li>';
                }

                ?>
            </ul>
        </div>
    </div>
</nav>
<!-- ###################### End Of Main Navigation ########################## -->