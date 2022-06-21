<?php

$path = __DIR__ . DIRECTORY_SEPARATOR;

define('TOOLKIT_DIR', $path . 'dcmtk' . DIRECTORY_SEPARATOR . 'bin');

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
  define('RUNNING_WINDOWS', 1);
} 
else {
  define('RUNNING_WINDOWS', 0);
}

if(RUNNING_WINDOWS) {
  define('BIN_DCMJ2PNM', TOOLKIT_DIR . '/dcmj2pnm.exe');
}
else {
  define('BIN_DCMJ2PNM', TOOLKIT_DIR . '/dcmj2pnm');
}