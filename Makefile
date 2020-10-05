projectname=wsp-autoscaling-demo
port=80
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

run:
	docker run --rm -p $(port):$(port) $(projectname):latest

run-dev:  
	docker run --rm -p $(port):$(port) -e WSP_APP_TIME=10 -e WSP_APP_USERS=5 $(projectname):latest

container:
	docker build -f Dockerfile -t $(projectname):latest .

enter-container:
	docker exec -it `docker container ls | grep $(projectname):latest | awk '{print($$1)}'` /bin/bash

get-container-id:
	docker container ls | grep $(projectname):latest | awk '{print($$1)}'

clean:	## Remove existing Docker container
	docker rmi $(projectname):latest