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
            "test42",
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
            "test",
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
            "abra",
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
            "cadabra",
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
            "http://php.com",   //link
            1,                  //rank
            $keywords           //keywords
        ),
        new Website(
            "http://c2la.com",
            2,
            $keywords
        ),
        new Website(
            "http://merde.com",
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
    <script src="js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="js/plugins/morris/morris.js"></script>
    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/lodash.js"></script>
    <script src="js/stopWords.js"></script>
    <script src="js/script.js"></script>

</head>
<body>

<script type="application/javascript">
    jQuery( function ( $ ) {
        "use strict";

        Morris.Bar(
            {
                barColors: [<?php buildStringFromArray($colors); ?>],
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

<div class="gray-bg" style="padding-top: 15px">

    <div class="row">
        <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">

                    <div class="input-group">
                        <input name="keywords" type="text" class="form-control" placeholder="Tap your keyword(s)" />
                        <span class="input-group-btn">
                            <input name="submit" value="Search" type="submit" class="btn btn-primary">
                        </span>
                    </div>


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

    </br>

    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="col-md-12" align="center">
                <h1>Presence on 50 websites</h1>
            </div>
            <div class="col-md-12">
                <div id="bar"></div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>


</div>
<!-- "Table" -->
<div class="row" style="margin-top: -20px">
    <div class="col-md-12" style="margin-top: -20px" align="center"><h1 class="label-primary">Results ranks</h1></div>
    <div class="col-md-12 no-margins" style="padding-top: 20px" ">

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
                                <h3><?php echo $ws->rank ?> : <a href="<?php echo $ws->link ?>"><?php echo $ws->link ?></a></h3>
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

    </div>
</div>

</body>
</html>