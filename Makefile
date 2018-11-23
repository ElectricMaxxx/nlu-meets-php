###############################################################################
## Do it with docker                                                         ##
###############################################################################
composer:
	docker exec example-app sh -c "composer install"

clear_cache:
	  # force clearing the cache
	  docker exec example-app sh -c "rm -rf var/cache/dev && rm -rf var/cache/test"
	  docker exec example-app sh -c "php -d memory_limit=-1 bin/console cache:warmup -n  -vvv"

setup: composer

###############################################################################
## Testing                                                                   ##
###############################################################################

sniff:
	echo "+++ Code Style und Sniffs+++

unit_test:
	echo "+++ Unit tests +++"

api_test:
	echo "+++ API tests i.e with behat+++

.PHONY: test
test: sniff unit_test api_test

###############################################################################
## Import/Setup                                                              ##
###############################################################################


###############################################################################
## Build, push, and release                                                  ##
###############################################################################

dev_ps:
	docker-compose ps

dev_up:
	docker-compose --verbose up -d

dev_down:
	docker-compose down

dev_logs:
	docker-compose logs -f --tail 1000

###############################################################################
## Build, push, and release                                                  ##
###############################################################################

docker_release: login
	@echo " + + + Build docker images + + + "
	docker build -f rasa_nlu/docker/Dockerfile_spacy_sklearn -t registry.gitlab.com/electricmaxxx/php-meets-nlu ./rasa_nlu/
	@echo " + + + Push docker images + + + "
	docker push registry.gitlab.com/electricmaxxx/php-meets-nlu

docker_login:
	@echo "+ + + Login into registry: ${REGISTRY} +  +  + "
	@docker login ${REGISTRY} -u ${REGISTRY_USER} -p ${REGISTRY_PASSWORD}

docker_logout:
	@echo "+ + + Logout from registry: ${REGISTRY} +  +  + "
	@docker logout ${REGISTRY}

#########################
## Run Symfony Console ##
#########################


ifeq (sf_console,$(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "run"
  COMMAND := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(COMMAND):;@:)
endif

.PONY: sf_console
sf_console:
	@echo "+ + + run symfony console command: ${COMMAND} +  +  + "
	@docker exec example-app sh -c "php -d memory_limit=-1 bin/console ${COMMAND}"
