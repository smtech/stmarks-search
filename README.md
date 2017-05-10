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
  4. Make your own `config.xml` configuration file describing your search domains and credentials.0
```bash
cd path/to/stmarks-search
cp config-example.xml config.xml
nano config.xml
```

Et voilà! Point your web browser at the root of the stmark-search -- http://yourserver.com/path/to/stmarks-search and let 'er rip!

### Next Steps

At the moment, this project is stalled out because of configuration issues around the [Google API Manager](https://console.developers.google.com/apis/dashboard). I can't create a new project and I get the following error:

> Create Project: stmarks-search
> APPHOSTING_ADMIN Cloud Service disabled by admin. Please contact admin to restore service. com.google.apps.framework.request.StatusException: <eye3 title='FAILED_PRECONDITION'/> generic::FAILED_PRECONDITION: APPHOSTING_ADMIN Cloud Service disabled by admin. Please contact admin to restore service.

Sounds like a permissions error.

Here's what the path forward would be:

  - Issue an OAuth ID and key for the Google Drive API in the API Manager
  - Set up a backing database for this project to cache API access tokens for users
  - Add a a Google API client to the Composer dependencies for this project. (I believe Google has a quickstart for doing this [in their documentation](https://developers.google.com/drive/v3/web/quickstart/php).)
  - Work out a scheme for including Google Drive folders in the `config.xml` file. I've been thinking it would be something like:
```xml
<google>
  <drive>
    <api>
      <id>OAuth ID here</id>
      <secret>OAuth secret here</secret>
    </api>
    <folder name="Faculty Resources" id="0Bx1atGpuKjk9YkNyb2Q1RUNoOWM" />
    <folder name="Student Resources" id="0Bx1atGpuKjk9anlxT2FPWjIwNDQ" />
  </drive>
  <calendars>
    <calendar name="Calendars would be neat too" />
  </calendars>
</google>
```
  - This would then give us the information we need to extend an create a `GooglePest` and a `GoogleDriveSearchDomain`, we hope.
  - `GoogleDriveSearchDomain` would make requests to the [Google Drive](https://github.com/smtech/stmarks-search/issues/3) RESTful API like (I mean, y'know, hypothetically) this one. This would, be informed by [this documentation](https://developers.google.com/drive/v3/reference/files/list) and [this documentation](https://developers.google.com/drive/v3/web/search-parameters). Just sayin'.
```rest
GET https://www.googleapis.com/drive/v3/files?q=%220Bx1atGpuKjk9YkNyb2Q1RUNoOWM%22+in+parents+and+%28name+contains+%22query%22+or+fullText+contains+%22query%22%29
```
  - I imagine that similar requests could be made around [Google Groups](https://github.com/smtech/stmarks-search/issues/6), Gmail, or [Google Calendar](https://github.com/smtech/stmarks-search/issues/13)  that would also be useful.
