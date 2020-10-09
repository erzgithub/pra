<link rel="stylesheet" href="<?php echo includeCss("hstyle") ?>"/>
<!--<link rel="stylesheet" href="<?php echo includeCss("raffleentries") ?>"/>-->
<div class="container">
    <div class="row">
         <div class="col-md-12">
            
            <div class="k-container">
                    <div class="row">
                         
                            <div>
                                <h1><i class="fa fa-shopping-bag fa-6" aria-hidden="true"></i>&nbsp;&nbsp;Raffle Entries</h1>
                                <button class="btn btn-sm btn-success" id="btnCount"><i class="fa fa-refresh" aria-hidden="true"></i></button>&nbsp;&nbsp;
                                &nbsp;Total:&nbsp;<span class="k-count"></span>
                            </div>
                    </div>   
                    <br>
                     <div class="row">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></div>
                                <input type="text" class="form-control" id="txtBarcode" autofocus/>
                            </div>
                    </div>   
                        
                <br>
                <button id="btnCheck" class="btn btn-primary btn-block btn-md"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Check</button>
            </div>
            <br>
            <div class="result">
            
            </div>
         </div>
    </div>
</div>
<div class="form">
    <?php
        if ($query){
            echo "<table class='table-hover tablesorter span5 center-table table table-condensed table-bordered'>";

                echo "<thead>";
                    echo "<tr>";
                        echo "<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "<th>Company Name</th>";
                    echo "</tr>";
                echo "</thead>";

                echo "<tbody>";
                    foreach ($query->result_array() as $row) {
                        echo "<tr>";
                            echo "<td>" .$row["FirstName"] ."</td>";
                            echo "<td>" .$row["LastName"] ."</td>";
                            echo "<td>" .$row["CompanyName"] ."</td>";
                        echo "</tr>";
                    }
                echo "</tbody>";

            echo "</table>";
        }
     ?>
</div>
                    <div class="col-md-2 loadersposition kit">
                        <img src="<?php echo asset_url("images/ajax-loader.gif") ?>"/>
                    </div>
<script type="text/javascript" src="<?php echo includeJs("rescript") ?>"></script>