build:
	docker buildx build --platform linux/arm64 -t prices/master -f ./docker/Dockerfile .

.PHONY: build
