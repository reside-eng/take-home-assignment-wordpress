<?php

// Get the properties data.
$properties = get_properties_data();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROPERTY LISTINGS</title>
</head>

<body>
    <div class="header"><h1>Property Listings </h1></div>
    <div class="container">
        <div class="single-property">
            <?php
            foreach( $properties as $property ) {

                $html  = '<div class="pic">';
                $html .= '<img src=' . $property['image'] . '>  </div>';
                $html .= '<div class="beds">' . $property['bedrooms'] . 'BR</div>';
                $html .= '<div class="bath">' . $property['baths'] . 'Bath </div> <div class="footage"> 2400 Sq Ft</div>';
                $html .= '<div class="icon" data-mls="' . $property['mls_id'] . '">';
                $html .= '<img class="favorite" src="' . WP_PLUGIN_DIR . '/side/images/heart-stroke.svg"><img class="favorite" src="' . WP_PLUGIN_DIR . '/side/images/heart-fill.svg" style="display:none"><div></div></div>';
                $html .= '<div class="detail-row"></div>';
                $html .= '<div class="price">$' . $property['price'] . '</div>';
                $html .= '<div class="address">' . $property['address']['full'] . ', ' . $property['address']['city'] . ', ' . $property['address']['state'] . '</div>';
                $html .= '<div class="date"> Listed ' . $property['list_date'] . '</div>';
                echo $html;
            }

            ?>

        </div>
    </div>
</body>
</html>
