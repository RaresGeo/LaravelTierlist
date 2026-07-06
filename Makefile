PROD := docker compose --env-file .env.prod -f docker-compose.prod.yml
DEV  := docker compose -f docker-compose.yml

.PHONY: prod-up prod-down prod-reset prod-logs build-prod build-prod-no-cache push-prod dev-up dev-down build-dev build-dev-no-cache


build-prod:
	$(PROD) build

build-prod-no-cache:
	$(PROD) build --no-cache

push-prod: build-prod
	$(PROD) push web php-fpm
	@# Extra immutable tag for traceability / rollback.
	@GIT_SHA="$$(git rev-parse --short HEAD 2>/dev/null || echo unknown)"; \
	if ! git diff --quiet 2>/dev/null || ! git diff --cached --quiet 2>/dev/null; then \
		GIT_SHA="$${GIT_SHA}-dirty"; \
	fi; \
	for img in $$($(PROD) config --images); do \
		case "$$img" in *:latest) ;; *) continue ;; esac; \
		sha_img="$${img%:latest}:$${GIT_SHA}"; \
		docker tag "$$img" "$$sha_img"; \
		docker push "$$sha_img"; \
	done

prod-up:
	$(PROD) up -d --build

prod-down:
	$(PROD) down

prod-reset:
	$(PROD) down -v

prod-logs:
	$(PROD) logs -f

# Bring up the workspace toolbox first and install PHP dependencies into the
# bind-mounted source, so vendor/ exists before php-fpm/web start. This avoids
# the first-boot race where php-fpm would otherwise install vendor itself and
# stay unhealthy long enough for web's dependency wait to give up.
dev-up:
	$(DEV) up -d workspace
	$(DEV) exec -T workspace composer install --no-interaction --no-progress --prefer-dist
	$(DEV) up -d
	$(DEV) exec -T workspace php artisan migrate --force

dev-down:
	$(DEV) down

build-dev:
	$(DEV) build

build-dev-no-cache:
	$(DEV) build --no-cache
