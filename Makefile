.PHONY: up down

up:
	docker compose up -d

down:
	docker compose down

login:
	docker exec -it clinicaodontologica-app-1 /bin/bash