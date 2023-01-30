# mc-backend

# Как запустить проект

```
git clone git@github.com:CuBeR116/ai-nature.git

cd ai-nature/docker

docker-compose up -d
docker exec -it ai-nature bash

composer install
```

# Как обучить нейросеть?
http://localhost:9002/ai/train

# Как посмотреть результат работы нейросети?

```http request
POST http://localhost:9002/ai/result {'values': [1, 2, 0, 1, 0, 2]}
```

URL ожидает JSON, заполненным массивом животных по зонам. 6 зон, максимум 2 животных на зону, всего животных 6.
```php
[1, 1, 2, 0, 1, 1]
[2, 0, 1, 2, 0, 1]
```