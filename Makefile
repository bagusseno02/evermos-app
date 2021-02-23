.PHONY: test checkpkey checkenv checkconsul dep build run buildrun push checkvar env-vanilla env-consul env-fileconsul env-file env-recuring-fileconsul

export CONSUL_PREFIX     ?=
export REPO_NAME         ?= $(shell git config --get remote.origin.url | cut -d'/' -f2 | cut -d'.' -f1)
export VERSION           ?= $(shell git show -q --format=%h)
#============== edit PORT ===================
export PORT              ?= 30001
#============================================
export APP_STORAGE_PATH  ?=/var/www/html/storage/logs

#ENV mode = vanilla, consul, fileconsul, file
export ENV_MODE          ?=fileconsul

ifeq ($(LOGS_PATH),)
  VOLUME=
else
  VOLUME=-v $(LOGS_PATH)/$(REPO_NAME):$(APP_STORAGE_PATH)
endif

test:
	do unit test

dep:
	rm composer.lock
	rm -rf ./vendor
	composer install

checkpkey:
ifndef BASE64_PRIVATE_KEY
	$(error BASE64_PRIVATE_KEY must be set.)
endif

checkenv:
ifndef APP_ENV
	$(error APP_ENV must be set.)
endif

checkconsul:
ifndef CONSUL_ADDR
	$(error CONSUL_ADDR must be set.)
endif

build: checkpkey checkenv checkconsul
	-docker image rm $(REPO_NAME):$(VERSION) --force
	docker build -t $(REPO_NAME):$(VERSION) \
	--build-arg APP_ENV=$(APP_ENV) \
	--build-arg BASE64_PRIVATE_KEY="$(BASE64_PRIVATE_KEY)" \
	--build-arg REPO_NAME="$(REPO_NAME)" \
	--build-arg CONSUL_PREFIX="$(CONSUL_PREFIX)" \
	--build-arg CONSUL_ADDR="$(CONSUL_ADDR)" \
	--build-arg ENV_MODE="$(ENV_MODE)" \
	-f ./deploy/Dockerfile .

run:
	-docker container rm $(REPO_NAME) --force
ifdef LOGS_PATH
	mkdir -p $(LOGS_PATH)/$(REPO_NAME)
endif
	docker run -d --name $(REPO_NAME) $(VOLUME) --expose=$(PORT) -p $(PORT):80 --restart unless-stopped $(REPO_NAME):$(VERSION)
ifdef NETWORK
	docker network connect $(NETWORK) $(REPO_NAME)
	docker restart $(REPO_NAME)
endif
	echo "success"

buildrun: build run

push:
	docker push $(REPO_NAME):$(VERSION)

checkvar: #for debugging purposes
	echo $(REPO_NAME):$(VERSION):$(PORT):$(APP_ENV)
ifdef NETWORK
	echo $(NETWORK)
endif
ifdef LOGS_PATH
	echo $(LOGS_PATH)
endif

env-vanilla:
	echo "" >> .env
	echo "apache2-foreground" > cmd.sh

env-consul:
	echo "" >> .env
	echo "./envconsul -consul-addr $(CONSUL_ADDR) -prefix $(CONSUL_PREFIX)$(REPO_NAME) -once" > cmd.sh
	echo "apache2-foreground" >> cmd.sh

env-fileconsul:
	./envconsul -consul-addr $(CONSUL_ADDR) -prefix $(CONSUL_PREFIX)$(REPO_NAME) -once -pristine env > .env
	echo "apache2-foreground" > cmd.sh

env-recuring-fileconsul:
	echo "./envconsul -consul-addr $(CONSUL_ADDR) -prefix $(CONSUL_PREFIX)$(REPO_NAME) -once -pristine env > .env" > cmd.sh
	echo "apache2-foreground" >> cmd.sh

env-file:
	echo "" >> .env
	echo "apache2-foreground" > cmd.sh
