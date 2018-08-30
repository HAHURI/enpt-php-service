# はふりのてすと

起動
```
$ docker-compose up -d
```

停止
```
$ docker-compose down
```

## URL

index.php  
http://localhost:9000

phpmyadmin  
http://localhost:9001


## 構成

```
.
├── app
│   └── index.php
├── mysql
│   └── conf
│       └── custom.cnf
│   └── data
│       └── .gitkeep
├── nginx
│   └── site.conf
├── docker-compose.yml
├── .gitignore
└── README.md
```
