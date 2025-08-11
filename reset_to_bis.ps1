Set-Location "D:\ProyectosWeb\CardioStaFe"
Write-Host "Ubicación actual: $(Get-Location)"
Write-Host "Haciendo fetch del remoto..."
& git fetch origin
Write-Host "Reseteando a la versión 08/08/2025 Bis..."
& git reset --hard cd6069cafcba9c785e7432a74cf3217788bf8802
Write-Host "Verificando el estado después del reset..."
& git log --oneline -3
Write-Host "Reset completado a la versión '08/08/2025 Bis.-'"
Read-Host "Presiona Enter para continuar"
