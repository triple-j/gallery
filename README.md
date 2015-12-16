Yet Another Gallery
===================

This project will display images like any other gallery out there, only with a
stronger focus on GIFs and looped videos.

This is more a proof-of-concept than anything.  If you are a frontend developer
and wish to add AJAX functionality to a site that you don't have access to
modify the backend, then you might find some useful code in this project.  (Do
not use this as a guide for implementing AJAX there are better ways than what's
used here)


Features
--------

* Works well with JavaScript enabled *or* disabled.
* Support for the browser's history buttons.
* Support for keyboard based navigation.
* Fullscreen image view.


Usage
-----

Make sure the `cache/` directory is writable.  Put images into the `gifs/`
directory.  Run the `tools/build_db.php` and `tools/populate_db.php` scripts
from a browser and enjoy.  Re-run the `tools/populate_db.php` script whenever
you add new images into the `gifs` directory.
