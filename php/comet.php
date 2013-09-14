<?php
//data file
define('DATA_FILE', '../log/data.log');

//get data
function getData() {
    return file_get_contents(DATA_FILE);
}

//update check
function getUpdatedData() {
    $data = getData();
    $temp = $data;
    while ($temp === $data) {
        $temp = getData();
        sleep(1);
    }
    return $temp;
}

//add data
function pushData($data) {
    if (!empty($data)) {
        $data = str_replace(array("\n", "\r"), '', $data) . '[' . date('c') . ']' . PHP_EOL;
        
        file_put_contents(DATA_FILE, $data, FILE_APPEND|LOCK_EX);
    }
    return getData();
}

if (isset($_GET['mode'])) {
    //guide to mode
    switch ($_GET['mode']) {
    
        //get data
        case 'view':
            $data = getData();
            break;

        //update check
        case 'check':
            $data = getUpdatedData();
            break;

        //save data
        case 'add':
            $data = pushData($_POST['data']);
            break;
    }

//output result
echo nl2br(htmlspecialchars($data, ENT_QUOTES));
}
