FROM mysql:5.7
ADD ./_/db/my.cnf /etc/mysql/my.cnf
RUN chmod 644 /etc/mysql/my.cnf
COPY ./_/db/initdb.d/init.sql /docker-entrypoint-initdb.d/init.sql
