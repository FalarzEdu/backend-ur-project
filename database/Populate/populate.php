<?php

require __DIR__ . '/../../config/bootstrap.php';

use Core\Database\Database;
use Database\Populate\UsersPopulate;
use Database\Populate\AdminsPopulate;
use Database\Populate\FeedbacksPopulate;
<<<<<<< Updated upstream
=======
use Database\Populate\SnackbarGoodsPopulate;
>>>>>>> Stashed changes

Database::drop();
Database::create();
Database::migrate();
UsersPopulate::populate();
AdminsPopulate::populate();
FeedbacksPopulate::populate();
<<<<<<< Updated upstream
=======
SnackbarGoodsPopulate::populate();
>>>>>>> Stashed changes
