# mc-backend

# Как запустить проект
## Docker
Для запуска проекта, требуется скачать [docker](https://www.docker.com/) и установить его.

Докер избавит от необходимости устанавливать требуюмую версию php 8.2, и установки с последующей конфигурации nginx, что намного быстрее и проще, нежели все это ставить на linux.

### Docker для Windows
Для windows, [документация об установке](https://docs.docker.com/desktop/install/windows-install/). Требуется нажать кнопку ***"Docker Desktop for Windows"***.

После завершения скачивания, открыть файл и запустить установку.
После окончания установки, требуется запустить docker. Можно из рабочего стола (***Docker Desktop***) или с меню пуска, где в поиск набрать его название ***"Docker"***. 

### Docker для Linux
Для систем Linux, ребуется перейти в [документацию](https://docs.docker.com/desktop/install/linux-install/) и там следовать всей инструкции для установки докера.

## Запуск проекта

```
// Склонить проект из github
git clone git@github.com:CuBeR116/ai-nature.git

// Перейти в директорию с yaml файлом для докера
cd ai-nature/docker

// Скачать все зависимости, и запустить контейнеры
docker-compose up -d

// Перейти в контейнер
docker exec -it nature bash

// Внутри контейнера запустить скачивание для требуемых пакетов и библиотек
composer install
```

# Как обучить нейросеть?

`http://localhost:9002/ai/train`

# Как посмотреть результат работы нейросети?

```http request
POST http://localhost:9002/ai/result {'values': [1, 2, 0, 1, 0, 2]}
```

URL ожидает JSON, заполненным массивом животных по зонам. 6 зон, максимум 2 животных на зону, всего животных 6.
```php
[1, 1, 2, 0, 1, 1]
[2, 0, 1, 2, 0, 1]
```