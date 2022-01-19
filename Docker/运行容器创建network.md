## docker跨容器访问需要在运行容器指定network
```bash
docker run --name Mineadmin -v $(pwd):/opt/www -p 9501:9501 -p 9503:9503 -p 9504:9504 --network xxxx  -it --entrypoint /bin/sh hyperf/hyperf:8.0-alpine-v3.15-swoole
```
