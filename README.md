Setup the database.php

in the app/bootstrap/start.php 
set the local machine name. In terminal type hostname this is the name of your machine, locally. 


composer update


art asset:publish --path="vendor/twbs/bootstrap/dist" "../assets/bootstrap"

art confide:migration
artisan entrust:migration

art migrate