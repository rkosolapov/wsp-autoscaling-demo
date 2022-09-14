FROM webdevops/php-nginx:7.4

RUN apt-get update && apt-get install -y \
    stress-ng \
    apache2-utils \
    procps 

COPY app/ /app
#COPY build.json* /app/build.json
WORKDIR /app
