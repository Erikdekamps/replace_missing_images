Replace missing images
----------------------

Replaces missing images with remote (dummy) images.
This is mostly a developer module for developers who don't want to see all those
missing images on local environments.


CONTENTS OF THIS FILE
--------------------

 * Introduction
 * Requirements
 * Installation
 * Configuration
 * Troubleshooting
 * Maintainers


INTRODUCTION
------------

Replace missing images is a simple module that replaces missing images with
configurable remote images.

 * For a full description of the module visit:
   https://www.drupal.org/project/replace_missing_images

 * To submit bug reports and feature suggestions, or to track changes visit:
   https://www.drupal.org/project/issues/replace_missing_images


REQUIREMENTS
------------

This module requires no modules outside of Drupal core.


INSTALLATION
------------

 * Install the Replace missing images module as you would normally install a
   contributed Drupal module.

   Visit https://www.drupal.org/docs/7/extend/installing-modules for further
   information.

CONFIGURATION
-------------

The following configuration options are available:

 * Predefined placeholder service
   A list of predefined placeholder services to use, like placekitten.com.
 * Placeholder image width
   A default width to configure for the placeholder images to use.
 * Placeholder image height
   A default height to configure for the placeholder images to use.
 * Custom placeholder service
   An url field to store a custom placeholder service, for instance:
   https://example.com/[width]/[height]
 * Unique image
   An option to configure whether or not to (try and) use unique images on page
   load. This adds a random hash to the url.


TROUBLESHOOTING
---------------

If the module is not shown in the list try deleting the module and try cloning
it again, or else try clearing the cache, and then try installing it.


MAINTAINERS
-----------

 * Erik de Kamps - https://www.drupal.org/u/erik-de-kamps

Supporting organization:

 * Lucius Digital - https://www.drupal.org/lucius-digital
