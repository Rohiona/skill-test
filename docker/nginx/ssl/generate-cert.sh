#!/bin/sh

# Generate self-signed SSL certificate for development
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout /etc/nginx/ssl/server.key \
  -out /etc/nginx/ssl/server.crt \
  -subj "/C=JP/ST=Tokyo/L=Tokyo/O=Development/CN=localhost"

echo "SSL certificate generated successfully"