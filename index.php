<?php
/**
 * Created by IntelliJ IDEA.
 * User: hdelo
 * Date: 13/10/2016
 * Time: 09:48
 */

include("includes/classes/Body.php");
include("includes/classes/Header.php");
include("includes/classes/Keyword.php");
include("includes/classes/Result.php");
include("includes/classes/WebSite.php");

include("includes/manage.php");

$keywords = [
    new Keyword(
        "couteau",
        new Body(
            30.0,   //h1
            30.0,   //h2
            10.0,   //h3
            40.0,   //h4
            50.0,   //strong
            10.0    //page
        ),
        new Header(
            40.0,   //title
            10.0    //metadescription
        )
    ),
    new Keyword(
        "cuisine",
        new Body(
            30.0,   //h1
            40.0,   //h2
            30.0,   //h3
            30.0,   //h4
            30.0,   //strong
            30.0    //page
        ),
        new Header(
            30.0,   //title
            30.0    //metadescription
        )
    ),
    new Keyword(
        "matériel",
        new Body(
            10.0,   //h1
            40.0,   //h2
            30.0,   //h3
            30.0,   //h4
            30.0,   //strong
            40.0    //page
        ),
        new Header(
            30.0,   //title
            20.0    //metadescription
        )
    ),
    new Keyword(
        "poël",
        new Body(
            30.0,   //h1
            40.0,   //h2
            0.0,   //h3
            30.0,   //h4
            0.0,   //strong
            10.0    //page
        ),
        new Header(
            15.0,   //title
            5.0    //metadescription
        )
    )
];

$websites = [
    new Website(
        "http://cuisine.com",   //link
        1,                  //rank
        $keywords           //keywords
    ),
    new Website(
        "http://materieldecuisine.fr",
        2,
        $keywords
    ),
    new Website(
        "http://lesitedescuistos.be",
        3,
        $keywords
    )
];

$result = new Result(
    $keywords,
    $websites
);




$colors = getColors();

$balises = getBalises();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/crowler.css" rel="stylesheet">
    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="js/jquery-2.1.1.js"></script>
    <!--<script src="js/inspinia.js"></script>-->
    <script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>
    <script src="js/plugins/chartJs/chart.min.js"></script>
    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/customStarter.js"></script>

</head>
<body>
<script type="application/javascript">
    jQuery( function ( $ ) {
        "use strict";

        Morris.Bar(
            {
                barColors: [<?php buildStringFromMultipleArray($colors); ?>],
                element: "bar",
                data: [<?php
                    computeBarChart($balises, $keywords);
                    $result = "";
                    $keywordsCount = count($keywords);
                    ?>],
                xkey: 'y',
                ykeys: [<?php
                    $j = 0;
                    while ($j < $keywordsCount) {
                        if ($j !== 0)
                            echo(",");
                        echo("\"" . $j . "\"");
                        $j++;
                    }
                    ?>],
                labels: [<?php buildStringFromKeywords($keywords); ?>]
            });
    });


</script>
<div class="sidebar-container">
    <div class="row" style="padding-top: 15px">
        <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <form action="index.php" method="post">
                    <div class="input-group">
                        <input name="keywords" type="text" class="form-control" placeholder="Tap your keyword(s)" />
                        <span class="input-group-btn">
                            <input name="submit" value="Search" type="submit" class="btn btn-primary">
                        </span>
                    </div>
                </form>

                <?php


                if(isset($_POST['submit'])){
                    echo($_POST["keywords"]);
                    //launchSearcher($_POST["keywords"]);
                }
                ?>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <div class="row" style="padding-top: 15px; margin-bottom: -20px">
        <div class="row progress progress-striped active">
            <div style="width: 35%;" class="progress-bar progress-primary">
            </div>
        </div>
    </div>
    <div class="gray-bg">

        </br>

        <div id="informationsFromCasper" class="row">
            <!--<div id="spinner" align="center" style="padding-top: 10px; padding-bottom: 20px">
                <div class="">
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                </div>
            </div>-->
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div id="casperSuccess" class="alert alert-success">
                    1. Casper script lunched successfully.
                    <br>2. Casper script began catching data from websites.
                    <br>3. Treatment of the data.
                </div>
                <!--<div id="casperInfo" class="alert alert-info">
                    Casper info.
                </div>
                <div id="casperWarn" class="alert alert-warning">
                    Casper warning.
                </div>
                <div id="casperError" class="alert alert-danger">
                    Casper error.
                </div>-->
            </div>
            <div class="col-md-3"></div>
        </div>

        <div id="presenceOnWebsites" class="row" style="padding-left: 30px; padding-right: 30px;">

            <div class="col-md-7">
                <div class="col-md-12" align="center">
                    <h1>Presence on 50 websites</h1>
                </div>
                <div class="col-md-12">
                    <div id="bar"></div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="col-md-12" align="center">
                    <h1>Average on 50 websites</h1>
                </div>
                <div class="row">
                    <div class="col-md-12" style="padding-bottom: 20px; padding-top: 20px">
                        <div class="col-md-2"></div>

                        <div class="col-md-10">
                            <?php
                            $countkw = count($keywords);
                            foreach ($keywords as $keyword){
                                ?>
                                <?php echo  "<div class=\"col-md-2\">" . $keyword->keywordName . "</div>" ?>

                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <?php

                    foreach ($balises as $balise){
                        $baliseString = (string)$balise;

                        ?>
                        <div class="col-md-12">
                            <div class="col-md-2"><?php echo $balise ?></div>
                            <div class="col-md-10">
                                <?php

                                foreach ($keywords as $keyword) {
                                    if (property_exists("Header", $baliseString)) {
                                        echo "<div class=\"col-md-2\">" . $keyword->header->{$baliseString} . "</div>";
                                    } else if (property_exists("Body", $baliseString)) {
                                        echo "<div class=\"col-md-2\">" . $keyword->body->{$baliseString} . "</div>";
                                    } else
                                        continue;
                                }
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>

        </div>


    </div>

    <div id="rankTablesTitle" class="row" style="margin-top: -20px" align="center"><h1 class="label-primary">Results ranks</h1></div>

    <!-- "Table" -->
    <div id="rankTables" class="row">
        <div class="col-md-12 no-margins" >

            <div class="col-md-4">
                <h2 style="color:white">First results</h2>
                <?php
                $i = 0;
                // for each element
                foreach ($websites as $ws) {

                    ?>
                    <script>
                        $(document).ready(function() {
                            $('#example<?php echo $i; ?>').DataTable( {
                                data:[<?php constructDataSet($ws, $balises); ?>],
                                columns: [
                                    { title: "Keywords" },
                                    { title: "h1" },
                                    { title: "h2" },
                                    { title: "h3" },
                                    { title: "h4" },
                                    { title: "Strong" },
                                    { title: "Page" }
                                ],
                                paging: true,
                                searching: false,
                                lengthMenu: [3, 5, 10, 15],
                                pageLength: 3,
                                autoWidth: false
                            } );
                        } );
                    </script>
                    <div class="ibox" style="margin-bottom: 10px">
                        <div class="ibox-content ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3><?php echo $ws->rank ?> : <a href="<?php echo $ws->link ?>"><?php echo $ws->link ?></a></h3>
                                    <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                        <table id="example<?php echo $i;?>" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php
                    $i++;
                }?>
            </div>

            <div class="col-md-4">
                <h2 align="center" style="color:white">Medium results</h2>
                <?php
                $i = 10;
                // for each element
                foreach ($websites as $ws) {

                    ?>
                    <script>
                        $(document).ready(function() {
                            $('#example<?php echo $i; ?>').DataTable( {
                                data:[<?php constructDataSet($ws, $balises); ?>],
                                columns: [
                                    { title: "Keywords" },
                                    { title: "h1" },
                                    { title: "h2" },
                                    { title: "h3" },
                                    { title: "h4" },
                                    { title: "Strong" },
                                    { title: "Page" }
                                ],
                                paging: true,
                                searching: false,
                                lengthMenu: [3, 5, 10, 15],
                                pageLength: 3,
                                autoWidth: false
                            } );
                        } );
                    </script>
                    <div class="ibox" style="margin-bottom: 10px">
                        <div class="ibox-content ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3><?php echo ($ws->rank + 23) ?> : <a href="<?php echo $ws->link ?>"><?php echo $ws->link ?></a></h3>
                                    <div class=" form-inline dt-bootstrap">
                                        <table id="example<?php echo $i;?>" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php
                    $i++;
                }?>
            </div>

            <div class="col-md-4">
                <h2 align="right" style="color:white">Last results</h2>
                <?php
                $i = 20;
                // for each element
                foreach ($websites as $ws) {

                    ?>
                    <script>
                        $(document).ready(function() {
                            $('#example<?php echo $i; ?>').DataTable( {
                                data:[<?php constructDataSet($ws, $balises); ?>],
                                columns: [
                                    { title: "Keywords" },
                                    { title: "h1" },
                                    { title: "h2" },
                                    { title: "h3" },
                                    { title: "h4" },
                                    { title: "Strong" },
                                    { title: "Page" }
                                ],
                                paging: true,
                                searching: false,
                                lengthMenu: [3, 5, 10, 15],
                                pageLength: 3,
                                autoWidth: false
                            } );
                        } );
                    </script>
                    <div class="ibox" style="margin-bottom: 10px">
                        <div class="ibox-content ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3><?php echo ($ws->rank + 47)?> : <a href="<?php echo $ws->link ?>"><?php echo $ws->link ?></a></h3>
                                    <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                        <table id="example<?php echo $i;?>" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <?php
                    $i++;
                }?>
            </div>

        </div>
    </div>
</div>

</body>
</html>