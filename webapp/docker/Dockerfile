FROM nginx:1.17-alpine

COPY default.conf /etc/nginx/conf.d/
COPY proxy.conf /etc/nginx/
COPY env.sh /etc/nginx/

ADD  dist.tar.gz /usr/share/nginx/html/

CMD ["sh", "-c", "/etc/nginx/env.sh ; nginx -g 'daemon off;'"]