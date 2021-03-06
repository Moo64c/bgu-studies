#!/bin/bash

rm -rf www/

bash scripts/build

cd www

cp sites/default/default.settings.php sites/default/settings.php
mkdir sites/default/files

drush si -y bgu --account-pass=admin --db-url=mysql://root:root@localhost/bgu --db-su=root -v
drush mi --all --user=1

chmod -R 777 sites/default/files

