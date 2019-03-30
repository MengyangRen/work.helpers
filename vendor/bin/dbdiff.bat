@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../dbdiff/dbdiff/dbdiff
php "%BIN_TARGET%" %*
