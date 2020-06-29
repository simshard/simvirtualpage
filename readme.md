## Inpsyde Challenge
_To write a WordPress plugin which makes available a custom endpoint on the WordPress site.
On navigating to that endpoint, the plugin will send an HTTP request to a REST API endpoint
 (https://jsonplaceholder.typicode.com/users).
 The plugin will parse the JSON response to build and display an HTML table.
Each row in the HTML table will show the details for a user, and links in the table will make another API request to the user-details endpoint.
Some kind of cache is required for the HTTP requests.
The plugin targets the current version of Wordpress and PHP version >7.0 ,and requires full Composer support.
The code should be compliant with Inpsyde code style and include automated unit tests, README and  license files_

 
## Project Setup and development environment ##

My development machine currently runs Windows 7, my IDE is MS Visual Code and Laragon is my web server manager.
To create a suitable development environment I used the wecodemore/wpstarter composer package to install a current edition of Wordpress and some development and other plugins (error-log-monitor, debug-bar, query-monitor, wp-super-cache etc. ).

I have not worked with Wordpress a great deal in the past two or three years , though I am used to using Wordpress to create websites and applications. In the last couple of years,especially since the advent of PHP7 ,Node and ES2015+,  I have sought to improve and update my coding skills. I have improved my understanding and use of OOP techniques and principles in PHP and Javascript , and learned to use frameworks like Laravel and Vue as well as tools such as Composer, Webpack, Git, Vagrant, Docker and PhpUnit etc.
I had to do some reading and research to get back up to speed with Wordpress and setting up a development environment using WPstarter and Composer.

Once I had created my development environment and reacquainted myself with the WP Codex and the Plugin handbook, the initial version of the plugin itself was created fairly quickly. The detail and quality requirements of the challenge brief required more development time, as well as study time.
I had an especially difficult time withe Unit testing requirement of the project brief. I have not attempted to create automated tests for Wordpress or Wordpress plugins before, although I have been learning TDD and testing in the context of building Laravel projects.
At first I went down the wrong rabbit hole of setting up the Wordpress Core testing system. This is especially difficult on a Windows machine and the official documentation is terrible. After some study I realised that the WP Core testing setup was not what was required for Unit testing a plugin as an isolated collection of code and so I studied Brain Monkey and Mockery.

## Plugin setup ##  
The plugin can be installed via Composer or by uploading the whole plugin archive to a wordpress installation.
The plugin includes Phpunit, Brain/Monkey and Mockery as dev dependencies for use in the automated testing.
After setup the virtual page /custom endpoint can be accessed at the URL
 _https://WEBSITEDOMAINURL/?users_

There are no configurable options or administration pages.

### Styling and CSS ###
Layout and CSS styling of the plugin templates is simple and basic but the layout is responsive.


### HTTP requests and  Caching considered ###
The plugin uses Wordpress HTTP API (*wp_remote_get()*) to make requests to the remote API endpoint and uses the  WP transient API to store the response data. The user data will not be re-requested fom the remote site  again unless the transient cache entry expires (after one hour).

Secondary api requests for the details of individual users are handled using an asynchronous Jquery Ajax script.  Response data for individual users are cached by javascript in a custom object defined by the script.The cache object exists in the browser window object scope and during the users session  subsequent requests are served with response data from the cache oibject rather than from the remote api.
This cached data persists for only as long as the users browser session lasts  or the page is refreshed.
 
In a small application, caching Jquery selectors is acheived by declaring all of your objects as variables and using the new variables throughout the script  rather than repeating the same selecter multiple times. Otherwise each use of a particular selecter requires Jquery to trawl the whole DOM again to get the results for the selecter call and then store it in another jQuery object.
 

### Unit Tests ##

The plugin contains some simple unit tests to check that the test environment is configured correctly and that Action hooks are added in the class constructor. After some struggle I managed to make use of Brain Monkey and Mockery to  carry out very basic tests. However I feel the  test suite I made does not cover enough aspects of the plugin class.