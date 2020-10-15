# wsp-autoscaling-demo
Autoscaling feature demo scenario for the Web Services Platform project.

## Initial configuration
1. setup two instances of this application
1. one instance is Loader, another is Consumer
1. use environment variables to configure the instances
1. for Consumer: 
    * set WSP_APP_MODE to 'CONSUMER'
1. for Loader: 
    * set WSP_APP_MODE to 'LOADER'
    * set WSP_APP_DOMAIN_TO_LOAD to the domain name of the Consumer instance, e.g., 'https://domain.com'

## Configuration options
The Loader instance can be configured with the following environment variables:
* WSP_APP_TIME - timeout for `ab` utility.  The load test will be run this number of seconds.
* WSP_APP_USERS - the number of simultaneous connections