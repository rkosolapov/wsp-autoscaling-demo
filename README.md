# wsp-autoscaling-demo
Autoscaling feature demo scenario for the Web Services Platform project.

# What's WSP

<p align="center">
<img src="https://github.com/rkosolapov/public_files/raw/main/wspIntro1.gif"/><br/><p>WSP is a SaaS Control Panel for AWS.  It allows you to run your application on AWS ECS in 10 minutes even you have no AWS experience and knowledge.</p><a align="center" class="typeform-share button" href="https://form.typeform.com/to/NLBJcfK0?typeform-medium=embed-snippet#source=github" data-mode="popup" style="display:inline-block;text-decoration:none;background-color:#3A7685;color:white;cursor:pointer;font-family:Helvetica,Arial,sans-serif;font-size:20px;line-height:50px;text-align:center;margin:0;height:50px;padding:0px 33px;border-radius:25px;max-width:100%;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-weight:bold;-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale;" data-size="100" target="_blank"><b>Watch the Demo</b></a><br/>Or see details here: https://github.com/rkosolapov/public_files/blob/main/WSP%201.x%20Whitepaper.pdf 
</p>


# How to work with this demo application

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
