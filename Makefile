.PHONY: up down

up:
	docker compose up -d

down:
	docker compose down

login:
	docker exec -it clinicaodontologica-app-1 /bin/bash

logs-db:
	docker logs -f clinicaodontologica-db-1

logs-app:
	docker logs -f clinicaodontologica-app-1