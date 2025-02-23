#!/bin/sh

chown www-data:www-data /var/www/public/assets/uploads
chmod 775 /var/www/public/assets/uploads

# sed -i 's/^user .*/user nginx;/' /etc/nginx/nginx.conf

exec nginx -g "daemon off;"
