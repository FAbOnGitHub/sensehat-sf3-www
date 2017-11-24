<?php
/**
 * Fait juste un appel système vers le Makefile pour nettoyer le cache
 *  via le compte Apache
 */

$iRC = 0;

$sDir = dirname($_SERVER['DOCUMENT_ROOT']);

$sExec = "/usr/bin/make";
if (! file_exists($sExec)) {
    if (! file_exists('/bin/make')) {
        die("No make command found");
    } else {
        $sExec = '/bin/make';
    }
}

$sPath = "PATH=" .getenv("PATH"). ':/bin:/usr/bin:';
putenv($sPath);
$sPath2 = getenv("PATH");
if ($sPath != $sPath2) {
    echo "<p>Misere sur le path</p>";
}
$sExec = "export PATH=$sPath; $sExec";
$sCmd = "$sExec -f Makefile --debug clean-by-apache >>/tmp/mymake.log  2>&1";
//$sCmd = "$sExec test >/tmp/mymake.log  2>&1";

$sCmd = '/usr/bin/php bin/console cache:clear --env=prod ; ';
$sCmd .= '/usr/bin/php bin/console cache:clear --env=dev ; ';
$sCmd .= '/usr/bin/php bin/console assets:install ;';



echo "<html><body>";
echo "<h1>Reseting cache</h1>\n";
echo "<pre>\n";
echo "
 PATH = $sPath
 sDir = $sDir
 sCmd = $sCmd
";
echo "</pre>\n";
echo "<hr />\n";
$iRes = chdir($sDir);
echo "<p>".($iRes?"'cd $sDir' : ok": "'cd $sDir' : failed")."</p>";
echo "<hr />\n";
echo "<pre>\n";
passthru($sCmd, $iRC);
echo "</pre>\n";

echo "[iRC=$iRC]\n";
echo "</body></html>";
exit ($iRC);


?>