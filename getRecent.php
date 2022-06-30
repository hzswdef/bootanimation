<?php

$folders = [];
$tmp = [];

foreach (glob(__DIR__ . '/tmp/*') as $folder) {
    $timestamp = filemtime($folder);
    
    $folders[] = [
        'path' => str_replace(__DIR__, '', $folder),
        'timestamp' => $timestamp
    ];
    
    $tmp[] = $timestamp;
}
array_multisort($tmp, SORT_DESC, $folders);
array_slice($folders, 0, 10);
#array_multisort($folders, array('timestamp'=>SORT_DESC));

foreach ($folders as $folder) {
    ?>
        <div class="recent-item">
            <img src="<? echo $folder['path'] . '/original.gif'; ?>" alt="bootanimation">
        </div>
    <?
}

?>