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
    <script src="js/plugins/chartJs/Chart.min.js"></script>
    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/customStarter.js"></script>
    <script src="js/stopWords.js"></script>
    <script src="js/lodash.js"></script>
    <script src="js/script.js"></script>

</head>
<body>
<script >
</script>
<div class="sidebar-container">
    <div class="row" style="padding-top: 15px">
        <div class="col-md-12">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                    <div class="input-group">
                        <input name="keywords" type="text" class="form-control" placeholder="Tap your keyword(s)" />
                        <span class="input-group-btn">
                            <input name="submit" value="Search" type="submit" class="btn btn-primary">
                        </span>
                    </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <div class="row" style="padding-top: 15px; margin-bottom: -20px">
        <div class="row progress progress-striped active">
            <div style="width: 0;" class="progress-bar progress-primary" id="progressBar">
            </div>
        </div>
    </div>
    <div class="gray-bg">

        </br>

        <div id="informationsFromCasper" class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div id="casperSuccess" class="alert alert-success">
                    1. Casper script lunched successfully.
                    <br>2. Casper script began catching data from websites.
                    <br>3. Treatment of the data.
                </div>
                <div id="casperInfo" class="alert alert-info">
                    Casper info.
                </div>
                <div id="casperWarn" class="alert alert-warning">
                    Casper warning.
                </div>
                <div id="casperError" class="alert alert-danger">
                    Casper error.
                </div>
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
                    <table id="average" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
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

                <div class="ibox" style="margin-bottom: 10px">
                    <div class="ibox-content ">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 id="website0"></h3>
                                <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                    <table id="websitekeywords0" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="ibox" style="margin-bottom: 10px">
                    <div class="ibox-content ">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 id="website1"></a></h3>
                                <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                    <table id="websitekeywords1" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="ibox" style="margin-bottom: 10px">
                    <div class="ibox-content ">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 id="website2"></h3>
                                <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                    <table id="websitekeywords2" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h2 align="center" style="color:white">Medium results</h2>

                <div class="ibox" style="margin-bottom: 10px">
                    <div class="ibox-content ">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 id="website23"></h3>
                                <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                    <table id="websitekeywords23" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="ibox" style="margin-bottom: 10px">
                    <div class="ibox-content ">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 id="website24"></a></h3>
                                <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                    <table id="websitekeywords24" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="ibox" style="margin-bottom: 10px">
                    <div class="ibox-content ">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 id="website25"></h3>
                                <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                    <table id="websitekeywords25" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h2 align="right" style="color:white">Last results</h2>

                    <div class="ibox" style="margin-bottom: 10px">
                        <div class="ibox-content ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 id="website47"></h3>
                                    <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                        <table id="websitekeywords47" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="ibox" style="margin-bottom: 10px">
                        <div class="ibox-content ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 id="website48"></a></h3>
                                    <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                        <table id="websitekeywords48" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="ibox" style="margin-bottom: 10px">
                        <div class="ibox-content ">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 id="website49"></h3>
                                    <div class=" form-inline dt-bootstrap " style="padding-top: 0px !important">
                                        <table id="websitekeywords49" role="grid" class="display" width="100%" style="padding-top: 0px !important"></table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>