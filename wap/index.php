<?php
include '../config.php';
include '../functions.php';

$xml = curl_get_xml($url, $encoding);

curl_manage_error($xml);

header('Content-type: text/vnd.wap.wml; charset='.$encoding);
echo '<?xml version="1.0" encoding="' . $encoding . '"?>' . PHP_EOL;
?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN" "http://www.wapforum.org/DTD/wml_1.1.xml"> 
<wml>
    <card title="Card1" id="Main" newcontext="false" ordered="true">
    <p align="center">
        <strong><?php echo $xml->channel->title; ?></strong>
    </p>
    <p align="left">
        <?php
        $cardnumber = 1;

        foreach ($xml->channel->item as $item) {

            if (mobile_cleanup($item->description) != NULL) {
                $cardnumber++;
                echo '<a href="#Card' . $cardnumber . '">' . $item->title . '</a><br/><br/>' . PHP_EOL;
            }

            if ($cardnumber == $max_elements) {
                break;
            }
        }
        ?>
    </p>
    </card>

    <?php
    $cardnumber = 1;
    foreach ($xml->channel->item as $item) {

        if (mobile_cleanup($item->description) != NULL) {
            $cardnumber++;
            ?>

            <card id="Card<?php echo $cardnumber ?>" title="<?php echo $item->title ?>">
            <p align="left">
                <?php echo mobile_cleanup($item->description); ?><br/>
            <anchor title="Ok">OK<go href="#Main" method="get" sendreferer="false"/></anchor>
        </p>
        </card>

        <?php
    }

    if ($cardnumber == $max_elements) {
        break;
    }
}
?>
</wml>
