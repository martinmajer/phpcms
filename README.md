phpcms
======

Extrémně jednoduchý a modulární CMS napsaný v PHP.


Instalace
---------

1. Nahrajte obsah repozitáře na server.
2. Založe novou MySQL databázi a importujte soubor `db.sql`.
3. V souborech `config.php` a `.htaccess` nastavte cestu k webu (defaultně `/phpcms`).
4. V souboru `config.php` nastavte přístupové údaje k databázi.
5. Instalace je dokončená.


Pro otestování administračního rozhraní přejděte na adresu `http://vase-instalace/admin/`. Při importu souboru `db.sql` byl vytvořen uživatelský účet `phpcms` s heslem `phpcms`.


Systémové požadavky
--------

Systém byl vytvořen pro verzi PHP 5.3 a MySQL 5.1. Na jiných verzích nebyl otestován.
