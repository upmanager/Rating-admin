@echo off
php artisan encrypt-source

cd ..\Admin-Dist
rmdir /s /q app\
rmdir /s /q bootstrap\
rmdir /s /q config\
rmdir /s /q database\
rmdir /s /q public\
rmdir /s /q resources\
rmdir /s /q routes\
rmdir /s /q storage\

xcopy /S ..\Rating-admin\build\ .\
xcopy ..\Rating-admin\composer.json .\ /Y

git add .
git commit -m update
git push

cd ..\Rating-admin

rmdir /s /q build\

