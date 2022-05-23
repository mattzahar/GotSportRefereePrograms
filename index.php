<?php
include ("top.php");
?>

    <body>
        <div class="container" style="margin: auto; padding: 5% 10%; min-height: 600px; background-size: cover; background-image: url('https://i.postimg.cc/4ywDr9fc/photo-1574629810360-7efbbe195018.jpg')">
            <div class="row text-center" style="height: 50%;">
                <a class="col-xl-4 col-sm-6 mb-5" href="<?php print 'https://vtsrc.com/addFirst.php'; ?>" style="color: inherit;text-decoration: inherit;">
                    <div class="rounded shadow-sm py-5 px-4">
                        <h5 class="mb-0">Add Report</h5>
                    </div>
                </a>
                <a class="col-xl-4 col-sm-6 mb-5" href="<?php print 'https://vtsrc.com/lookup.php'; ?>" style="color: inherit;text-decoration: inherit;">
                    <div class="rounded shadow-sm py-5 px-4">
                        <h5 class="mb-0">Lookup Reports</h5>
                    </div>
                </a>
                <a class="col-xl-4 col-sm-6 mb-5" href="<?php print 'https://vtsrc.com/other.php';?>" style="color: inherit;text-decoration: inherit;">
                    <div class="rounded shadow-sm py-5 px-4">
                        <h5 class="mb-0">Other Info/Payment</h5>
                    </div>
                </a>
            </div>
        </div>
        <!--<div class="container" style="margin: auto">
            <div class="row">
                <div class="col-md">
                    <a href="<?php /*print 'http://' . $_SERVER['HTTP_HOST'] . '/addFirst.php'; */?>">
                        <button class ="btn btn-light" type="button" style="width: 30%; height: 100%;">
                            Add Report
                        </button>
                    </a>
                </div>

                <div class="col-sm">
                    <a href="<?php /*print 'http://' . $_SERVER['HTTP_HOST'] . '/lookup.php'; */?>">
                       <button class ="btn btn-light" type="button">Lookup Reports</button>
                   </a>
                </div>

               <div class="col-sm">
                   <a href="<?php /*print 'http://' . $_SERVER['HTTP_HOST'] . '/other.php'; */?>">
                       <button class ="btn btn-light" type="button">Other Info/Payment</button>
                   </a>
               </div>
           </div>
       </div>-->
    </body>

<?php
include ("footer.php");
?>