<?php

/**
 * Updates files that live outside the module directory.
 *
 * The updater runs before this package is copied into the module directory,
 * therefore every source path is relative to the update package itself.
 */
$updater->CopyFiles(
    'install/wizards/sporina/easy_site/site/templates/sporina_easy_site',
    'templates/sporina_easy_site'
);

foreach (['banner', 'contacts', 'footer', 'header', 'news', 'system.settings'] as $componentName) {
    $updater->CopyFiles(
        'install/components/sporina/' . $componentName,
        'components/sporina/' . $componentName
    );
}

// Do not copy init.php: preserve the site's existing customizations.
$updater->CopyFiles('install/php_interface/form_handler.php', 'php_interface/form_handler.php');
$updater->CopyFiles('install/php_interface/constants.php', 'php_interface/constants.php');
