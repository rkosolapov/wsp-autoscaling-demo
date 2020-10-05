# wsp-autoscaling-demo
Autoscaling feature demo scenario for the Web Services Platform project.

## Configuration options
Can be configured with the following environment variables:
* WSP_APP_TIME - timeout for `ab` utility.  The load test will not be longer than this number of seconds.
* WSP_APP_USERS - the number of simultaneous connections