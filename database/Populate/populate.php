<?php

require __DIR__ . '/../../config/bootstrap.php';

use Core\Database\Database;
use Database\Populate\UsersPopulate;
use Database\Populate\AdminsPopulate;

Database::drop();
Database::create();
Database::migrate();
UsersPopulate::populate();
AdminsPopulate::populate();
