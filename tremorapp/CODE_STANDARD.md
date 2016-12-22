#Server Side

##PHP

*   We will use [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md) &  [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) Standards.
*   Overview
    *   Files MUST use only `<?php` and `<?=` tags.
    *   Namespaces and classes MUST follow an "autoloading" PSR: [[PSR-0], [PSR-4]].
    *   Class names MUST be declared in `StudlyCaps`.
    *   Class constants MUST be declared in all upper case with underscore separators.
    *   Method names MUST be declared in `camelCase`.
*   Additional
    *   Filename for Model,Controllers will Follow `StudlyCaps.php`.
    *   Folder naming and structure are taken from `Laravel` package.
    *   Variable names will be all camelCase.
    *   Function arguments are just variables used in a specific context, so they should follow the same guidelines as variable names.
    *   The opening and closing parenthesis should be in a new line. 

##DB (ORM)

*   Laravel Query Builder methods should be used to interact with the DB
*   The LQB method selectRaw() should be used very minimal.
*   DB, table & column name should follow all lower separated by underscores.

##Blade Views

*   The files should be placed under resources/views
*   Files should be grouped in appropriate folder depending on the functionality
*   Filename for views will follow hyphen separated small case `abc-xyz.blade.php`
*   Try to write minimal amount of JS code in view files

---
#Client Side

##CSS

*   All CSS files should be placed inside public/css folder.
*   CSS files will be loaded before the body begins
*   Class names, attributes and values should be written in lowercase, with words separated by dashes `.main-image`
*   Don't use too generic names for classes
*   No inline CSS should be used
