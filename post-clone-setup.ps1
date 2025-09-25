# PowerShell script to create Laravel storage folders after cloning
# Usage: Ejecuta este script en la raíz del proyecto

$folders = @(
    "storage",
    "storage\app",
    "storage\framework",
    "storage\framework\cache",
    "storage\framework\sessions",
    "storage\framework\views",
    "storage\logs"
)
foreach ($folder in $folders) {
    if (!(Test-Path $folder)) {
        New-Item -ItemType Directory -Path $folder | Out-Null
    }
}
Write-Host "Carpetas de storage creadas correctamente."
