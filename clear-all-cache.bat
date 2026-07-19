@echo off
cls
echo.
echo ============================================
echo   PRESENCE TEEN - CACHE CLEAR UTILITY
echo ============================================
echo.
echo Clearing all Laravel caches...
echo.

php artisan optimize:clear

echo.
echo ✅ All Laravel caches cleared!
echo.
echo NEXT STEPS:
echo -----------
echo 1. Go to your browser
echo 2. Press: Ctrl + Shift + Delete
echo 3. Select: "All time"
echo 4. Click: "Clear data"
echo 5. Go to form page
echo 6. Press: Ctrl + Shift + R (hard refresh)
echo.
echo.
pause
