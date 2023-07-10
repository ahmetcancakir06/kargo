<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CRM</title>
    <link href="<?php echo $bootstrap_css; ?>" rel="stylesheet">
</head>

<body>
<div id="printet" style="height:130px;width:240px;">

    <?php
    echo "Contact  : "/*.$musterisonuc['phonenumber']*/."<br>";
    echo "FULL NAME: "/*.$musterisonuc['company']*/."<br>";
    echo "Adress   : "/*.$result['adres']*/."<br>";
    echo "Suburb   : "/*.$result['mahalle']*/."<br>";
    echo "State    : "/*.$result['eyalet']*/." & "/*.$result['postakodu']*/;
    ?>
</div>
<script src="<?php echo $jquery_js; ?>"></script>
<script src="<?php echo $print_js; ?>"></script>
<script>
    var options={
        importCSS: false,
        loadCSS:"<?php echo $bootstrap_css; ?>",
        pageTitle:"<h1>KARGO PRİNT</h1>",
        header:null,
        footer:null
    }
    $( document ).ready(function() {

        $('#printet').printThis(options);
    });

</script>
</body>
</html>
