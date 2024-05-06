run these scripts to load the database:

symfony console doctrine:database:create  (if the database doesn't exist yet)

symfony console doctrine:migrations:execute 'DoctrineMigrations\Version20240506143517'

symfony console doctrine:fixtures:load --group=group1 --purge-exclusions=user_auth

symfony console doctrine:fixtures:load --group=group2 --purge-exclusions=user_auth --append

symfony console doctrine:fixtures:load --group=group3 --purge-exclusions=user_auth --append
