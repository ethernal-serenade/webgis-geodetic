FROM postgres

RUN apt-get update \
    && apt-get install wget -y \
    && apt-get install postgresql-14-postgis-3 -y \
    && apt-get install postgis -y

ARG POSTGRES_PASSWORD
ARG POSTGRES_DB

ENV POSTGRES_PASSWORD=$POSTGRES_PASSWORD
ENV POSTGRES_DB=$POSTGRES_DB
COPY /postgres/initial.sql  /docker-entrypoint-initdb.d/
