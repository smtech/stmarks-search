# St. Mark’s Search

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/smtech/stmarks-search/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/smtech/stmarks-search/?branch=master)

A proof-of-concept project to develop a search engine that transparently spans the school's various information repositories, allowing students and faculty to find resources -- no matter where they were posted!

This project is made of two parts:

  1. A server app that provides a RESTful API for a configurable range of searches across a range of different sources (a.k.a. search domains). This is written in PHP, with the object model defined in [src/](src/) -- and documented in [doc/](https://htmlpreview.github.io/?https://raw.githubusercontent.com/smtech/stmarks-search/master/doc/namespaces/smtech.StMarksSearch.html) and the actual API hosted from [api/v1/](api/v1/). The configuration of the the actual search domains is stored in `config.xml` (an example is [config-example.xml](config-example.xml)).
  2. A client app that presents a user-facing GUI to search the aggregated search domains. This is built as a React JavaScript app and the source is in [client/](client/) and is served out of `client/build/` ([.htaccess](.htaccess) redirects requests to the root directory to the client app directory).

Why two parts? Well… I wanted to protect my various API and server credentials on the server, and PHP is quite convenient for making these API requests. However, PHP is not multi-threaded (yet), so making a series of _simultaneous_ API requests is difficult. However, if the server-side PHP app protects my credentials, the client-side JavaScript app can multi-thread and make the requests of the API simultaneously, integrating the results as they come back.

### Install

  1. Clone the repository to your web-server document directory (clearly, I am assuming that you use Apache -- you will need to adapt my `.htaccess` files for IIS or Nginx or Node as needed).
    ```bash
    git clone https://github.com/smtech/stmarks-search.git path/to/dir/stmarks-search
    ```
  2. Install the PHP dependencies using [Composer](http://getcomposer.org).
    ```bash
    cd path/to/stmarks-search
    composer install -o --prefer-dist
    ```
  3. Install the Node dependencies using [NPM](https://www.npmjs.com) and build the client app.
    ```bash
    cd path/to/stmarks-search/client
    npm install
    npm run build
    ```
  4. Configure the search domains.
    ```bash
    cd path/to/stmarks-search
    cp config-example.xml config.xml
    ```
    Edit `config.xml` to reflect your particular search domains.

Et voilà! Point your web browser at the root of the stmark-search -- http://yourserver.com/path/to/stmarks-search and let 'er rip!
