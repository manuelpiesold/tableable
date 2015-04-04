#!/usr/bin/env php
<?php

buildHtml();
echo "\n";
buildCss();
echo "\nDone.";

function buildHtml() {
    $srcFile  = "raw.html";
    $destFile = "index.html";

    echo "build $destFile from $srcFile\n";

    $content = file_get_contents( $srcFile );
    $pattern = "!<link rel=\"import\" href=\".*?\">!";
    $matches = array();

    while ( preg_match($pattern, $content, $matches) ) {

        $searched    = $matches[0];
        $htmlFile    = str_replace( "<link rel=\"import\" href=\"", "", str_replace( "\">", "", $matches[0] ) );
        $replacement = file_get_contents( $htmlFile );

        echo "  replacement for $htmlFile\n";
        $content = str_replace( $searched, $replacement, $content );

        $matches = array();
    }

    file_put_contents( $destFile, $content );
}

function buildCss() {
    echo "build guhberlin.css from guhberlin.less\n";
    exec( "lessc less/guhberlin.less > css/guhberlin.css" );
}

?>