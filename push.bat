@echo off
git init
git add .
git commit -m "Initial commit"
git branch -M main
git remote add origin https://github.com/DharmikRavat/abacus_websites.git
git push -u origin main
echo.
echo Push complete!
pause
