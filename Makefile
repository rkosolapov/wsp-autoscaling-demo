projectname=wsp-autoscaling-demo
port=80
help: ## Display help on make targets
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

run:	## Run a report in Docker container
	docker run --rm -p $(port):$(port) $(projectname):latest

container:	## Build a Docker container from the Dockerfile
	docker build -f Dockerfile -t $(projectname):latest .

enter-container:
	docker exec -it `docker container ls | grep $(projectname):latest | awk '{print($$1)}'` /bin/bash

get-container-id:
	docker container ls | grep $(projectname):latest | awk '{print($$1)}'

clean:	## Remove existing Docker container
	docker rmi $(projectname):latest