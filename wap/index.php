<?php
include '../config.php';
include '../functions.php';

$curl = curl_init();

curl_setopt_array($curl, Array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_ENCODING => 'UTF-8'
));

$data = curl_exec($curl);
curl_close($curl);

libxml_use_internal_errors(true);
$xml = simplexml_load_string($data);

if ($xml === false) {
    echo "Failed loading XML\n";
    foreach (libxml_get_errors() as $error) {
        echo "\t", $error->message;
    }
    die();
}


header("Content-type: text/vnd.wap.wml; charset=UTF-8");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
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