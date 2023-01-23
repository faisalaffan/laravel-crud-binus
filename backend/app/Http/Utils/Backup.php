<?php

namespace App\Http\Utils;

trait Backup
{
    public function backupDb()
    {
        $command = 'mysqldump -u root -p --databases db_name > db_name.sql';
        exec($command);
    }

    public function restoreDb()
    {
        $command = 'mysql -u root -p db_name < db_name.sql';
        exec($command);
    }
}
