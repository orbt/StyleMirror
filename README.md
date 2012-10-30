Style Mirror
============

The style mirror provides a library of components using the [Resource Mirror][1] to optimize style resources and mirror
assets on a local server.

This library contains these main components:

* `Aggregator`: Utility for aggregating a collection of CSS files (with media types).
* `ResourceScanner`: Utility for scanning a CSS file for other resources linked via `url(path/to/resource.png)`.
* `LinkedResourceFetcher`: Subscribes to the resource materialize event and scans CSS resources for other linked
  resources to materialize.

Installation using Composer
---------------------------

Add the following to the `"require"` list in your `composer.json` file:

```
    "orbt/style-mirror": "dev-master"
```

Run composer to update dependencies:

```bash
$ composer update
```

Or to just download this library:

```bash
$ composer update orbt/style-mirror
```

License
-------

This library is licensed under the MIT License. See the LICENSE file for detailed license information.



[1]: http://github.com/orbt/ResourceMirror
