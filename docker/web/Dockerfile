FROM nginx:1.18

# 環境変数（TZ）を定義
ENV TZ=UTC

# nginx config file,  Nginxの設定ファイルをコンテナ内にコピーして対応づける
COPY ./docker/web/*.conf /etc/nginx/conf.d/

WORKDIR /var/www/html