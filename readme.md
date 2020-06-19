## Inpsyde Challenge


Restart and rebuild demo plugin using better development techniques learned

reinstall  a WP instance using Composer and WP-starter
now have empty wp with preinstalled theme  and plugins
wp super cache is active and server has zend opcode cache - I swerved memcached because windows 
next 
* check out brainmonkey  https://brain-wp.github.io/BrainMonkey/
* get wp-plugin boilerplate
* inpsyde code standards 


###############################################
big gap in notes  when i eg.
study regex,learned markdown,read the codex and stackexchange,etc...
study use of composer in wordpress context
 wp-setup to create a dev environment and install   dev packages  for testing ,coding standards- not using any other packages like guzzle or caching  libraries -keep it simple and just use wp itself
read about unit testing wp and tried to setup wp test framework - well i did but that is not what I need - dont need wp core and their test suite - this unit testing just need s phpunit to test plugin class- dicovered monkey/brain was the thing to use and studyied all that not yet used in actual unit test but its set up and ready to go
XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
**TO FIX** plugin initialises badly some times and errors at first view with 
*Uncaught Error: json_decode() expects parameter 1 to be string, null given*


Testing works & plugin works but has faults  -query monitor and transients and options written to db
etc shows that certain parts of plugin are not working or are working but i am doing it wrong
eg activate /deactivate not working - transients are not set as expected and WP **add_rewrite_rule** not happening   though **add rewrite endpoint** works fine -that  gives me url  like  ***inpsyde-challenge.test/?users***
i would prefer **inpsyde-challenge.test/users**

plugin hooks ivpRewrite method onto the init hook  which is bad cos it happens on every request and constant flushing of rewrite must be avoided  - refactor to  sort this and probably add it using
the **register_activation_hook** HOOK 
need refactor   initialize plugin    plugin loader methods


setting up testing-use TDD to find and fix problems with plugin class and methods
improvements to  class and methods improve structure and organization of plugin  features and functionality  and best practice

check that phpunit is setup correctly
   i had to read the docs 
check that the plugin class is actually instantiated and that phpunit can find it
-- better understand namespacing  and fix usage-had to RTD
TO DO - Monkey use and mocking of WP funcs in plugin class

      - test plugin class methods

Refactoring plugin structure
static instance? what are the advantages - is it the thing to do or not is this the singleton pattern im employing err maybe -
 





### Caching considered
dont go down the memcached /memcache  rabbithole  just now
memcached not on my windows dev server -laragon supports it but documentation is a bit sketchy
ditto redis - too much for now -
keep it simple and use wp Transients api
 
HTTP caching   
ajax/jquery call using promise

-  to store transients used to cache http reponses
 
v1 used guzzle for Remote Api call- which is fine  but 
keep it simpler  and use wp http API  instead
*wp_remote_get()*

remote api call returns the whole dataset of users
but the brief requests  calling the api once more  for individual users
first  api call to users endpoint is all cached in a  wp transient 
 but we will call the api again in a jquery ajax way  for each individual user even though we could just get the data from what we already have
 not sure about tools for unit testing  jquery stuff - have not tried JQUNIT etc yet

_________

### TODO
* gitignore
* tidyup and push to new Git repo
*  
* caching of api calls  
     * using wp transients
     
     * code cache js code for jquery  calls
                                   
 

 

 
   

 
 
#### Testing
 

* tests- the endpoint or virt page exists returns 200
* the virt page makes a http request to api
* a json result set  is returned
* page contains ++ whatever  
some of this is feature/acceptance testing not unit and thats not in the brief
 