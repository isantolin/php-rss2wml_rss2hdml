<?php
$url = "http://clarin.feedsportal.com/c/33088/f/577682/index.rss";


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
        die();
    }
}

header("Content-type: text/x-hdml");
echo "<?xml version=\"1.0\"?>\n";
?>
<HDML VERSION="3.0" PUBLIC="TRUE"> 
    <DISPLAY NAME="<?php echo $xml->channel->title; ?>">
        Headlines:<BR>
        <?php
        $cardnumber = 1;
        $accesskey = 0;
        foreach ($xml->channel->item as $item) {
            $cardnumber++;
            $accesskey++;

            if (strip_tags($item->description) != NULL) {
                echo '<LINE><A TASK=GO DEST=#card' . $cardnumber . ' LABEL="Go" ACCESSKEY=' . $accesskey . '>' . $item->title . '</A>' . PHP_EOL;
            }
        }
        ?>
    </DISPLAY>
    <?php
    $cardnumber = 1;
    foreach ($xml->channel->item as $item) {
        $cardnumber++;

        if (strip_tags($item->description) != NULL) {
            echo '<DISPLAY NAME="card' . $cardnumber . '">' . strip_tags($item->description) . '</DISPLAY>' . PHP_EOL;
        }
    }
    ?>
</HDML>
