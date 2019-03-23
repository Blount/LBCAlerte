from php:7.2-apache

# allow the apache web server to use port 80
RUN apt-get update && apt-get install libcap2-bin -y
RUN setcap CAP_NET_BIND_SERVICE=+eip /usr/sbin/apache2

# setup the check cron job
RUN apt-get update && apt-get -y install cron
RUN echo "*/30 * * * * php /var/www/html/check.php" > /etc/cron.d/check-cron
RUN chmod 0644 /etc/cron.d/check-cron

# sources
COPY app /var/www/html/app
COPY var /var/www/html/var
COPY lib /var/www/html/lib
COPY others /var/www/html/others
COPY static /var/www/html/static
COPY api.php /var/www/html/api.php
COPY check.php /var/www/html/check.php
COPY index.php /var/www/html/index.php
COPY version.php /var/www/html/version.php
COPY bootstrap.php /var/www/html/bootstrap.php

# allow the php runtime to write in the var directory
RUN chown www-data:www-data /var/www/html/var

# run
CMD cron && apachectl -d /etc/apache2 -f /etc/apache2/apache2.conf -e info -DFOREGROUND
